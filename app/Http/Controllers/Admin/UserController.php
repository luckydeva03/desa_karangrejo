<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'status.required' => 'Status wajib dipilih.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'avatar.max' => 'Ukuran gambar maksimal 5MB.'
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);
        $data['password'] = Hash::make($request->password);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('posts');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload only if file is present
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            try {
                // Delete old avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $data['avatar'] = $this->uploadAvatar($request->file('avatar'));
            } catch (\Exception $e) {
                // Log error and continue without avatar update
                Log::error('Avatar upload failed: ' . $e->getMessage());
            }
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === (auth()->user()?->id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        
        if (empty($userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Pilih minimal satu user untuk dihapus.');
        }

        // Prevent deleting current user
        $currentUserId = auth()->user()?->id;
        if (in_array($currentUserId, $userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $users = User::whereIn('id', $userIds)->get();
        
        foreach ($users as $user) {
            // Delete avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', count($userIds) . ' user berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating current user
        if ($user->id === (auth()->user()?->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah status akun sendiri.'
            ]);
        }

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diubah.',
            'status' => $user->status
        ]);
    }

    private function uploadAvatar($file)
    {
        try {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'avatars/' . $filename;
            
            // Try to resize image with Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file)->cover(200, 200);
            Storage::disk('public')->put($path, (string) $image->encode());
            
            return $path;
        } catch (\Exception $e) {
            // Fallback: save original file without resize
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'avatars/' . $filename;
            
            // Store original file
            $file->storeAs('avatars', $filename, 'public');
            
            return $path;
        }
    }
}