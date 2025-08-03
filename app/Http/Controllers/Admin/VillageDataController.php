<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageData;
use App\Models\VillageDataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VillageDataController extends Controller
{
    public function index(Request $request)
    {
        $query = VillageData::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('label', 'like', '%' . $request->search . '%');
        }

        $villageData = $query->orderBy('type')->orderBy('sort_order')->paginate(15);

        return view('admin.village-data.index', compact('villageData'));
    }

    public function create()
    {
        $dataTypes = VillageDataType::active()->ordered()->get();
        return view('admin.village-data.create', compact('dataTypes'));
    }

    public function store(Request $request)
    {
        // Debug: Log request data
        Log::info('=== VILLAGE DATA STORE START ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request data:', $request->all());
        
        try {
            $validated = $request->validate([
                'type' => 'required|in:demografi,geografis,ekonomi,pendidikan,kesehatan',
                'label' => 'required|string|max:255',
                'value' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'icon' => 'nullable|string|max:100',
                'sort_order' => 'nullable|integer|min:0'
            ], [
                'type.required' => 'Kategori data wajib dipilih.',
                'label.required' => 'Label data wajib diisi.',
                'value.required' => 'Nilai data wajib diisi.',
                'sort_order.integer' => 'Urutan harus berupa angka.'
            ]);
            
            Log::info('Validation passed:', $validated);

            $data = $request->only(['type', 'label', 'value', 'description', 'icon', 'sort_order']);
            
            // Set default sort_order if not provided
            if (empty($data['sort_order'])) {
                $maxOrder = VillageData::max('sort_order') ?? 0;
                $data['sort_order'] = $maxOrder + 1;
                Log::info('Set default sort_order: ' . $data['sort_order']);
            }
            
            Log::info('Data to create:', $data);
            
            $villageData = VillageData::create($data);
            Log::info('VillageData created successfully with ID: ' . $villageData->id);
            Log::info('Created data:', $villageData->toArray());
            
            Log::info('Redirecting to index...');
            return redirect()->route('admin.village-data.index')
                ->with('success', 'Data desa berhasil ditambahkan.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
                
        } catch (\Exception $e) {
            Log::error('VillageData creation failed:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $villageData = VillageData::findOrFail($id);
        return view('admin.village-data.show', compact('villageData'));
    }

    public function edit($id)
    {
        $villageData = VillageData::findOrFail($id);
        
        return view('admin.village-data.edit', compact('villageData'));
    }

    public function update(Request $request, $id)
    {
        // Debug logging for hosting
        Log::info('=== VILLAGE DATA UPDATE START ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Session ID: ' . $request->session()->getId());
        Log::info('CSRF Token from request: ' . $request->input('_token'));
        Log::info('CSRF Token from session: ' . $request->session()->token());
        
        try {
            $villageData = VillageData::findOrFail($id);
            
            $validated = $request->validate([
                'type' => 'required|in:demografi,geografis,ekonomi,pendidikan,kesehatan',
                'label' => 'required|string|max:255',
                'value' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'icon' => 'nullable|string|max:100',
                'sort_order' => 'nullable|integer|min:0'
            ], [
                'type.required' => 'Kategori data wajib dipilih.',
                'label.required' => 'Label data wajib diisi.',
                'value.required' => 'Nilai data wajib diisi.',
                'sort_order.integer' => 'Urutan harus berupa angka.'
            ]);

            Log::info('Validation passed for update');
            
            $villageData->update($request->only(['type', 'label', 'value', 'description', 'icon', 'sort_order']));
            
            Log::info('Village data updated successfully', ['id' => $id]);

            return redirect()->route('admin.village-data.index')
                ->with('success', 'Data desa berhasil diperbarui.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed on update:', $e->errors());
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
                
        } catch (\Exception $e) {
            Log::error('Village data update failed:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $villageData = VillageData::findOrFail($id);
        $villageData->delete();

        return redirect()->route('admin.village-data.index')
            ->with('success', 'Data desa berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:village_data,id'
        ]);

        try {
            $count = VillageData::whereIn('id', $request->ids)->count();
            VillageData::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} data desa berhasil dihapus."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ], 500);
        }
    }
}