<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    private array $sections = [
        'leader'          => 'Ketua Umum',
        'vice'            => 'Wakil Ketua Umum',
        'staff'           => 'Sekretaris & Bendahara',
        'department'      => 'Kepala Bidang',
        'humas'           => 'Humas & Kelembagaan',
        'board_pembina'   => 'Dewan Pembina',
        'board_penasihat' => 'Dewan Penasihat Kehormatan',
    ];

    public function index()
    {
        $structures = OrganizationalStructure::ordered()->get()->groupBy('section');
        $sections   = $this->sections;
        return view('admin.structure.index', compact('structures', 'sections'));
    }

    public function create()
    {
        $sections = $this->sections;
        return view('admin.structure.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section'    => 'required|string',
            'title'      => 'required|string|max:255',
            'name'       => 'required|string|max:255',
            'icon'       => 'nullable|string|max:100',
            'photo'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable',
        ]);

        // boolean() membaca nilai: "1"/"on" = true, "0"/kosong = false
        $validated['is_active']  = $request->boolean('is_active') ? 1 : 0;
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['created_by'] = Auth::guard('admin')->id();
        $validated['updated_by'] = Auth::guard('admin')->id();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('people', 'public');
        }

        OrganizationalStructure::create($validated);

        return redirect()->route('admin.structure.index')
            ->with('success', 'Data "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function edit(OrganizationalStructure $structure)
    {
        $sections = $this->sections;
        return view('admin.structure.edit', compact('structure', 'sections'));
    }

    public function update(Request $request, OrganizationalStructure $structure)
    {
        $validated = $request->validate([
            'section'      => 'required|string',
            'title'        => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'icon'         => 'nullable|string|max:100',
            'photo'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'remove_photo' => 'nullable',
            'sort_order'   => 'nullable|integer|min:0',
            'is_active'    => 'nullable',
        ]);

        $validated['is_active']  = $request->boolean('is_active') ? 1 : 0;
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['updated_by'] = Auth::guard('admin')->id();

        $oldPhoto = $structure->photo;

        if ($request->hasFile('photo')) {
            // Simpan foto baru dulu, baru hapus yang lama
            $validated['photo'] = $request->file('photo')->store('people', 'public');
            if ($oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        } elseif ($request->boolean('remove_photo') && $oldPhoto) {
            // Hanya hapus kalau remove_photo benar-benar bernilai 1
            Storage::disk('public')->delete($oldPhoto);
            $validated['photo'] = null;
        }

        unset($validated['remove_photo']);
        $structure->update($validated);

        return redirect()->route('admin.structure.index')
            ->with('success', 'Data "' . $structure->name . '" berhasil diperbarui.');
    }

    public function destroy(OrganizationalStructure $structure)
    {
        $name = $structure->name;
        if ($structure->photo) {
            Storage::disk('public')->delete($structure->photo);
        }
        $structure->delete();

        return redirect()->route('admin.structure.index')
            ->with('success', 'Data "' . $name . '" berhasil dihapus.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:organizational_structures,id',
        ]);

        foreach ($request->order as $index => $id) {
            OrganizationalStructure::where('id', $id)->update([
                'sort_order' => $index + 1,
                'updated_by' => Auth::guard('admin')->id(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}