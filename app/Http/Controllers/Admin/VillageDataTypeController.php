<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageDataType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VillageDataTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataTypes = VillageDataType::ordered()->paginate(10);
        return view('admin.village-data-types.index', compact('dataTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.village-data-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug logging
        Log::info('=== VILLAGE DATA TYPE STORE START ===');
        Log::info('Request data:', $request->all());
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:village_data_types',
                'description' => 'nullable|string',
                'color' => 'required|string|in:primary,secondary,success,danger,warning,info,light,dark',
                'icon' => 'nullable|string|max:255',
                'sort_order' => 'nullable|integer|min:0'
                // Remove is_active validation since checkbox sends "on" value
            ]);
            
            Log::info('Validation passed:', $validated);

            $data = $request->only(['name', 'description', 'color', 'icon', 'sort_order']);
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active'); 

            // Set sort_order if not provided
            if (empty($data['sort_order'])) {
                $data['sort_order'] = (VillageDataType::max('sort_order') ?? 0) + 1;
                Log::info('Set default sort_order: ' . $data['sort_order']);
            }

            Log::info('Data to create:', $data);
            
            $villageDataType = VillageDataType::create($data);
            Log::info('VillageDataType created successfully with ID: ' . $villageDataType->id);

            return redirect()->route('admin.village-data-types.index')
                ->with('success', 'Tipe data berhasil ditambahkan.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
                
        } catch (\Exception $e) {
            Log::error('VillageDataType creation failed:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan tipe data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VillageDataType $villageDataType)
    {
        $villageData = $villageDataType->villageData()->paginate(10);
        return view('admin.village-data-types.show', compact('villageDataType', 'villageData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VillageDataType $villageDataType)
    {
        return view('admin.village-data-types.edit', compact('villageDataType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VillageDataType $villageDataType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:village_data_types,name,' . $villageDataType->id,
            'description' => 'nullable|string',
            'color' => 'required|string|in:primary,secondary,success,danger,warning,info,light,dark',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $villageDataType->update($data);

        return redirect()->route('admin.village-data-types.index')
            ->with('success', 'Tipe data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VillageDataType $villageDataType)
    {
        // Check if this data type is being used
        if ($villageDataType->villageData()->count() > 0) {
            return redirect()->route('admin.village-data-types.index')
                ->with('error', 'Tipe data tidak dapat dihapus karena masih digunakan oleh data desa.');
        }

        $villageDataType->delete();

        return redirect()->route('admin.village-data-types.index')
            ->with('success', 'Tipe data berhasil dihapus.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(VillageDataType $villageDataType)
    {
        $villageDataType->update([
            'is_active' => !$villageDataType->is_active
        ]);

        $status = $villageDataType->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.village-data-types.index')
            ->with('success', "Tipe data berhasil {$status}.");
    }
}
