<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\CulturalGallery;
use App\Models\Cultural;
use App\Models\CulturalGeodata;

class CulturalController extends Controller
{
    /**
     * ========================
     * BAGIAN USER / FRONTEND
     * ========================
     */
    public function dashboard()
    {
        $ids = [3, 22, 1];
        $culturals = Cultural::whereIn('id', $ids)
            ->orderByRaw("FIELD(id, " . implode(',', $ids) . ")")
            ->get();

        return view('dashboard', compact('culturals'));
    }

    public function index(Request $request)
    {
        $query = Cultural::query();

        if ($request->filled('starts_with')) {
            $query->where('name', 'LIKE', $request->starts_with . '%');
        }

        if ($request->has('sort')) {
            $query->orderBy('name', $request->sort === 'desc' ? 'desc' : 'asc');
        }

        $culturals = $query->paginate(9)->withQueryString();

        return view('cultural.index', compact('culturals'));
    }

    public function show(Cultural $cultural)
    {
        $cultural->load(['galleries', 'mapdata']);
        return view('cultural.cultural_detail', compact('cultural'));
    }

    /**
     * Find/Search cultural items
     */
    public function find(Request $request)
    {
        // Ambil kata pencarian dari input
        $q = $request->input('q', '');
        $query = $q;
        $results = collect();

        if (!empty($q)) {
            $results = Cultural::where('name', 'LIKE', "%{$q}%")
                ->orWhere('description', 'LIKE', "%{$q}%")
                ->orWhere('category', 'LIKE', "%{$q}%")
                ->orWhere('location', 'LIKE', "%{$q}%")
                ->with('mapdata')
                ->get();

            if ($results->count() === 1) {
                $first = $results->first();
                if (
                    $first->has_map &&
                    $first->mapdata &&
                    $first->mapdata->latitude &&
                    $first->mapdata->longitude
                ) {
                    return redirect(url('/map') . '?cultural_id=' . $first->id);
                }
            }
        }

        return view('find', compact('results', 'query'));
    }

        public function map()
        {
            $culturalData = Cultural::with('mapdata')
                ->where('has_map', true)
                ->whereHas('mapdata')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'description' => $item->description,
                        'category' => $item->category,
                        'location' => $item->location,
                        'image' => $item->image,
                        'latitude' => optional($item->mapdata)->latitude,
                        'longitude' => optional($item->mapdata)->longitude,
                    ];
                });

            return view('map', compact('culturalData'));
        }

        // Admin map view
        public function mapAdmin()
        {
            $culturalData = Cultural::with('mapdata')
                ->where('has_map', true)
                ->whereHas('mapdata')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'description' => $item->description,
                        'category' => $item->category,
                        'location' => $item->location,
                        'image' => $item->image,
                        'latitude' => optional($item->mapdata)->latitude,
                        'longitude' => optional($item->mapdata)->longitude,
                    ];
                });

            return view('Admin.map_admin', compact('culturalData'));
        }

        public function mapData()
        {
            $culturals = Cultural::with(['mapdata', 'galleries'])
                ->where('has_map', true)
                ->get();

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => [],
            ];

            foreach ($culturals as $cultural) {
                if ($cultural->mapdata && $cultural->has_map) {
                    $geojson['features'][] = [
                        'type' => 'Feature',
                        'geometry' => [
                            'type' => 'Point',
                            'coordinates' => [
                                $cultural->mapdata->longitude,
                                $cultural->mapdata->latitude,
                            ],
                        ],
                        'properties' => [
                            'id' => $cultural->id,
                            'name' => $cultural->name,
                            'description' => $cultural->description,
                            'category' => $cultural->category,
                            'location' => $cultural->location,
                            'image' => $cultural->image,
                        ],
                    ];
                }
            }

            return response()->json($geojson);
        }

        // ========================
        // ADMIN / BACKEND
        // ========================
        public function create()
        {
            return view('Admin.cultural.create');
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'category'    => 'required|string|max:255',
                'description' => 'required|string',
                'history'     => 'nullable|string',
                'nowaday'     => 'nullable|string',
                'cult_now'    => 'nullable|string',
                'location'    => 'required|string',
                'video_url'   => 'nullable|url',
                'thumbnail'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'has_map'     => 'nullable|boolean',
                'latitude'    => 'nullable|numeric|between:-90,90',
                'longitude'   => 'nullable|numeric|between:-180,180',
            ]);

            $hasMap = $request->boolean('has_map');

            $disk = Storage::disk('public');
            $base = Str::slug($validated['name']);

            // Thumbnail
            $thumbnailFile = $request->file('thumbnail');
            $ext = $thumbnailFile->getClientOriginalExtension();
            $thumbnailName = $base . '.' . $ext;
            $counter = 1;
            while ($disk->exists($thumbnailName)) {
                $thumbnailName = $base . '-' . $counter . '.' . $ext;
                $counter++;
            }
            $disk->putFileAs('', $thumbnailFile, $thumbnailName);

            $cultural = Cultural::create([
                'name'        => $validated['name'],
                'category'    => $validated['category'],
                'description' => $validated['description'],
                'history'     => $validated['history'] ?? null,
                'nowaday'     => $validated['nowaday'] ?? null,
                'cult_now'    => $validated['cult_now'] ?? null,
                'location'    => $validated['location'],
                'video_url'   => $validated['video_url'] ?? null,
                'image'       => $thumbnailName,
                'has_map'     => $hasMap,
            ]);

            if ($hasMap) {
                $lat = $request->input('latitude');
                $lng = $request->input('longitude');
                if (!empty($lat) && !empty($lng)) {
                    CulturalGeodata::updateOrCreate(
                        ['cultural_id' => $cultural->id],
                        ['latitude' => $lat, 'longitude' => $lng]
                    );
                }
            }

            // Galleries
            $images = $request->file('images');
            if ($images && is_array($images)) {
                $idx = 1;
                foreach ($images as $image) {
                    if (!$image) continue;
                    $ext = $image->getClientOriginalExtension();
                    $galleryBase = $base . '-gallery-' . $idx;
                    $galleryName = $galleryBase . '.' . $ext;
                    $gCounter = 1;
                    while ($disk->exists($galleryName)) {
                        $galleryName = $galleryBase . '-' . $gCounter . '.' . $ext;
                        $gCounter++;
                    }
                    $disk->putFileAs('', $image, $galleryName);
                    CulturalGallery::create(['cultural_id' => $cultural->id, 'image_path' => $galleryName]);
                    $idx++;
                }
            }

            return redirect()->route('admin.dashboard_admin')->with('success_create', [
                'title' => 'Berhasil!',
                'message' => 'Data kebudayaan berhasil ditambahkan' . ($hasMap ? ' beserta titik peta.' : '.'),
            ]);
        }

        public function edit(Cultural $cultural)
        {
            $cultural->load(['galleries', 'mapdata']);
            return view('Admin.cultural.edit', compact('cultural'));
        }

        public function update(Request $request, Cultural $cultural)
        {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'category'    => 'required|string|max:255',
                'description' => 'required|string',
                'history'     => 'nullable|string',
                'nowaday'     => 'nullable|string',
                'cult_now'    => 'nullable|string',
                'location'    => 'required|string',
                'video_url'   => 'nullable|url',
                'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'replace_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'remove_galleries.*' => 'nullable|integer',
                'has_map'     => 'nullable|boolean',
                'latitude'    => 'nullable|numeric|between:-90,90',
                'longitude'   => 'nullable|numeric|between:-180,180',
                'remove_thumbnail' => 'nullable|boolean',
                'remove_galleries' => 'nullable|array',
            ]);

            $hasMap = $request->boolean('has_map');
            $disk = Storage::disk('public');
            $base = Str::slug($validated['name']);

            if ($request->boolean('remove_thumbnail') && $cultural->image) {
                $disk->delete($cultural->image);
                $cultural->image = null;
            }

            if ($request->hasFile('thumbnail')) {
                if ($cultural->image) $disk->delete($cultural->image);
                $thumbnailFile = $request->file('thumbnail');
                $ext = $thumbnailFile->getClientOriginalExtension();
                $thumbnailName = $base . '.' . $ext;
                $counter = 1;
                while ($disk->exists($thumbnailName)) {
                    $thumbnailName = $base . '-' . $counter . '.' . $ext;
                    $counter++;
                }
                $disk->putFileAs('', $thumbnailFile, $thumbnailName);
                $cultural->image = $thumbnailName;
            }

            $cultural->update([
                'name'        => $validated['name'],
                'category'    => $validated['category'],
                'description' => $validated['description'],
                'history'     => $validated['history'] ?? null,
                'nowaday'     => $validated['nowaday'] ?? null,
                'cult_now'    => $validated['cult_now'] ?? null,
                'location'    => $validated['location'],
                'video_url'   => $validated['video_url'] ?? null,
                'has_map'     => $hasMap,
            ]);

            if ($hasMap) {
                $lat = $request->input('latitude');
                $lng = $request->input('longitude');
                if (!empty($lat) && !empty($lng)) {
                    CulturalGeodata::updateOrCreate(['cultural_id' => $cultural->id], ['latitude' => $lat, 'longitude' => $lng]);
                } else {
                    CulturalGeodata::where('cultural_id', $cultural->id)->delete();
                }
            } else {
                CulturalGeodata::where('cultural_id', $cultural->id)->delete();
            }

            $removeGalleries = $request->input('remove_galleries');
            if ($removeGalleries && is_array($removeGalleries)) {
                foreach ($removeGalleries as $galleryId) {
                    if (!is_numeric($galleryId)) continue;
                    $gallery = CulturalGallery::find($galleryId);
                    if ($gallery && $gallery->image_path) {
                        $disk->delete($gallery->image_path);
                        $gallery->delete();
                    }
                }
            }

            $replaceGalleries = $request->file('replace_gallery');
            if ($replaceGalleries && is_array($replaceGalleries)) {
                foreach ($replaceGalleries as $galleryId => $file) {
                    if (!$file) continue;
                    $gallery = CulturalGallery::find($galleryId);
                    if (! $gallery) continue;
                    if ($gallery->image_path) $disk->delete($gallery->image_path);
                    $ext = $file->getClientOriginalExtension();
                    $galleryName = $base . '-gallery-' . $galleryId . '.' . $ext;
                    $gCounter = 1;
                    while ($disk->exists($galleryName)) {
                        $galleryName = $base . '-gallery-' . $galleryId . '-' . $gCounter . '.' . $ext;
                        $gCounter++;
                    }
                    $disk->putFileAs('', $file, $galleryName);
                    $gallery->image_path = $galleryName;
                    $gallery->save();
                }
            }

            $images = $request->file('images');
            if ($images && is_array($images)) {
                $idx = 1;
                foreach ($images as $image) {
                    if (!$image) continue;
                    $ext = $image->getClientOriginalExtension();
                    $galleryBase = $base . '-gallery-' . $idx;
                    $galleryName = $galleryBase . '.' . $ext;
                    $gCounter = 1;
                    while ($disk->exists($galleryName)) {
                        $galleryName = $galleryBase . '-' . $gCounter . '.' . $ext;
                        $gCounter++;
                    }
                    $disk->putFileAs('', $image, $galleryName);
                    CulturalGallery::create(['cultural_id' => $cultural->id, 'image_path' => $galleryName]);
                    $idx++;
                }
            }

            return redirect()->route('admin.dashboard_admin')->with('success_update', [
                'title' => 'Berhasil!',
                'message' => 'Data kebudayaan berhasil diperbarui' . ($hasMap ? ' beserta titik peta.' : '.'),
            ]);
        }

        public function destroy(Cultural $cultural)
        {
            $name = $cultural->name;

            if ($cultural->image) {
                Storage::disk('public')->delete($cultural->image);
            }

            $galleries = CulturalGallery::where('cultural_id', $cultural->id)->get();
            foreach ($galleries as $gallery) {
                if ($gallery->image_path) Storage::disk('public')->delete($gallery->image_path);
                $gallery->delete();
            }

            CulturalGeodata::where('cultural_id', $cultural->id)->delete();

            $cultural->delete();

            $referer = request()->headers->get('referer');
            if (str_contains($referer ?? '', '/admin/map')) {
                return redirect()->route('admin.map_admin')->with('deleted', ['name' => $name]);
            }

            return redirect()->route('admin.dashboard_admin')->with('success_delete', [
                'title' => 'Data Dihapus',
                'message' => 'Data kebudayaan dan lokasinya berhasil dihapus.',
            ]);
        }

        // Note: Plus Code and Google Geocoding usage removed — system accepts latitude/longitude only.
    }
