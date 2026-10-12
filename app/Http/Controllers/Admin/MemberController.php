<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

class MemberController extends Controller
{
    private function findMember(string $encryptedId): Member
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException) {
            abort(404);
        }

        return Member::findOrFail($id);
    }

    public static function encryptId(int $id): string
    {
        return Crypt::encryptString($id);
    }

    public function index(Request $request)
    {
        $query = Member::orderBy('sort_order')->orderBy('id');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $members         = $query->paginate(15)->withQueryString();
        $totalMembers    = Member::count();
        $activeMembers   = Member::where('is_active', true)->count();
        $inactiveMembers = Member::where('is_active', false)->count();

        return view('admin.member.index', compact(
            'members', 'totalMembers', 'activeMembers', 'inactiveMembers'
        ));
    }

    public function create()
    {
        $logoSizes = $this->getLogoSizeOptions();
        return view('admin.member.create', compact('logoSizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'logo_size'  => 'required|in:member-large-logo,member-small-logo',
            'is_active'  => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle upload logo
        if ($request->hasFile('logo')) {
            $file     = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/members'), $filename);
            $validated['logo'] = $filename;
        }

        $validated['is_active']  = $request->has('is_active') ? 1 : 0;
        // Kalau kosong, anggota baru masuk paling bawah
        $validated['sort_order'] = $request->input('sort_order') ?? ((int) Member::max('sort_order') + 1);
        $validated['created_by'] = Auth::guard('admin')->id();
        $validated['updated_by'] = Auth::guard('admin')->id();

        Member::create($validated);

        return redirect()->route('admin.member.index')
            ->with('success', 'Anggota "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function edit(string $encryptedId)
    {
        $member    = $this->findMember($encryptedId);
        $logoSizes = $this->getLogoSizeOptions();
        return view('admin.member.edit', compact('member', 'logoSizes', 'encryptedId'));
    }

    public function update(Request $request, string $encryptedId)
    {
        $member    = $this->findMember($encryptedId);
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'logo_size'  => 'required|in:member-large-logo,member-small-logo',
            'is_active'  => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle upload logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($member->logo && file_exists(public_path('images/members/' . $member->logo))) {
                @unlink(public_path('images/members/' . $member->logo));
            }
            $file     = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/members'), $filename);
            $validated['logo'] = $filename;
        }

        // Hapus logo tanpa upload pengganti
        if ($request->remove_logo == '1' && !$request->hasFile('logo')) {
            if ($member->logo && file_exists(public_path('images/members/' . $member->logo))) {
                @unlink(public_path('images/members/' . $member->logo));
            }
            $validated['logo'] = null;
        }

        $validated['is_active']  = $request->has('is_active') ? 1 : 0;
        // Kalau kosong, pertahankan urutan yang sekarang
        $validated['sort_order'] = $request->input('sort_order') ?? $member->sort_order;
        $validated['updated_by'] = Auth::guard('admin')->id();

        $member->update($validated);

        return redirect()->route('admin.member.index')
            ->with('success', 'Anggota "' . $member->name . '" berhasil diperbarui.');
    }

    public function destroy(string $encryptedId)
    {
        $member = $this->findMember($encryptedId);

        if ($member->logo && file_exists(public_path('images/members/' . $member->logo))) {
            @unlink(public_path('images/members/' . $member->logo));
        }

        $name = $member->name;
        $member->delete();

        return redirect()->route('admin.member.index')
            ->with('success', 'Anggota "' . $name . '" berhasil dihapus.');
    }

    public function toggleStatus(string $encryptedId)
    {
        $member = $this->findMember($encryptedId);
        $member->update([
            'is_active'  => !$member->is_active,
            'updated_by' => Auth::guard('admin')->id(),
        ]);

        $status = $member->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', 'Anggota "' . $member->name . '" berhasil ' . $status . '.');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer',
            'offset'  => 'nullable|integer|min:0',
        ]);

        $offset = (int) $request->input('offset', 0);

        DB::transaction(function () use ($request, $offset) {
            foreach ($request->order as $index => $id) {
                Member::where('id', $id)->update([
                    'sort_order' => $offset + $index + 1,
                ]);
            }
        });

        return response()->json(['success' => true]);
    }

    private function getLogoSizeOptions(): array
    {
        return [
            'member-large-logo' => 'Logo Besar',
            'member-small-logo' => 'Logo Kecil',
        ];
    }
}