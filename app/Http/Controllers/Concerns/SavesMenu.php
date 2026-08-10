<?php

namespace App\Http\Controllers\Concerns;

use App\Models\MenuSection;
use App\Models\MenuItem;
use App\Models\Restaurant;

trait SavesMenu
{
    protected function saveMenu(Restaurant $restaurant, array $sections): void
    {
        $restaurant->menuSections()->delete();

        foreach (array_values($sections) as $si => $sectionData) {
            $name = trim($sectionData['name'] ?? '');
            if (!$name) continue;

            $section = MenuSection::create([
                'restaurant_id' => $restaurant->id,
                'name'          => $name,
                'sort_order'    => $si,
            ]);

            foreach (array_values($sectionData['items'] ?? []) as $ii => $itemData) {
                $itemName = trim($itemData['name'] ?? '');
                if (!$itemName) continue;

                MenuItem::create([
                    'menu_section_id' => $section->id,
                    'name'            => $itemName,
                    'description'     => $itemData['description'] ?? null,
                    'price'           => is_numeric($itemData['price'] ?? '') ? $itemData['price'] : null,
                    'sort_order'      => $ii,
                ]);
            }
        }
    }
}
