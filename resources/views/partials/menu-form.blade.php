{{-- Menu Builder Partial --}}
{{-- Usage: @include('partials.menu-form', ['sections' => $restaurant->menuSections ?? collect()]) --}}

<div id="menu-builder">
    @php $sections = $sections ?? collect(); @endphp

    @foreach($sections as $si => $section)
    <div class="menu-section-block border rounded p-3 mb-3" data-section="{{ $si }}">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <input type="text" name="menu[{{ $si }}][name]" class="form-control font-weight-bold"
                   placeholder="Section name (e.g. Starters)" value="{{ old("menu.$si.name", $section->name) }}" required>
            <button type="button" class="btn btn-sm btn-danger ml-2 remove-section" style="white-space:nowrap">
                <i class="fa fa-trash"></i> Remove Section
            </button>
        </div>
        <div class="menu-items-list">
            @foreach($section->items as $ii => $item)
            <div class="menu-item-row row align-items-start mb-2 border-top pt-2">
                <div class="col-md-4">
                    <input type="text" name="menu[{{ $si }}][items][{{ $ii }}][name]"
                           class="form-control form-control-sm" placeholder="Item name"
                           value="{{ old("menu.$si.items.$ii.name", $item->name) }}" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="menu[{{ $si }}][items][{{ $ii }}][price]"
                           class="form-control form-control-sm" placeholder="Price (e.g. 9.90)"
                           value="{{ old("menu.$si.items.$ii.price", $item->price) }}">
                </div>
                <div class="col-md-5">
                    <input type="text" name="menu[{{ $si }}][items][{{ $ii }}][description]"
                           class="form-control form-control-sm" placeholder="Short description (optional)"
                           value="{{ old("menu.$si.items.$ii.description", $item->description) }}">
                </div>
                <div class="col-md-1 text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">&times;</button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary add-item mt-2">
            <i class="fa fa-plus"></i> Add Item
        </button>
    </div>
    @endforeach
</div>

<button type="button" id="add-section" class="btn btn-outline-primary btn-sm mb-3">
    <i class="fa fa-plus"></i> Add Section
</button>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var sectionCount = {{ $sections->count() }};
    var builder = document.getElementById('menu-builder');

    function itemRowHtml(si, ii) {
        return '<div class="menu-item-row row align-items-start mb-2 border-top pt-2">' +
            '<div class="col-md-4"><input type="text" name="menu['+si+'][items]['+ii+'][name]" class="form-control form-control-sm" placeholder="Item name" required></div>' +
            '<div class="col-md-2"><input type="text" name="menu['+si+'][items]['+ii+'][price]" class="form-control form-control-sm" placeholder="Price"></div>' +
            '<div class="col-md-5"><input type="text" name="menu['+si+'][items]['+ii+'][description]" class="form-control form-control-sm" placeholder="Short description (optional)"></div>' +
            '<div class="col-md-1 text-right"><button type="button" class="btn btn-sm btn-outline-danger remove-item">&times;</button></div>' +
        '</div>';
    }

    function sectionHtml(si) {
        return '<div class="menu-section-block border rounded p-3 mb-3" data-section="'+si+'">' +
            '<div class="d-flex justify-content-between align-items-center mb-2">' +
                '<input type="text" name="menu['+si+'][name]" class="form-control font-weight-bold" placeholder="Section name (e.g. Starters)" required>' +
                '<button type="button" class="btn btn-sm btn-danger ml-2 remove-section" style="white-space:nowrap">Remove Section</button>' +
            '</div>' +
            '<div class="menu-items-list">' + itemRowHtml(si, 0) + '</div>' +
            '<button type="button" class="btn btn-sm btn-outline-secondary add-item mt-2">+ Add Item</button>' +
        '</div>';
    }

    document.getElementById('add-section').addEventListener('click', function () {
        var div = document.createElement('div');
        div.innerHTML = sectionHtml(sectionCount);
        builder.appendChild(div.firstChild);
        sectionCount++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.add-item')) {
            var block = e.target.closest('.menu-section-block');
            var si = block.dataset.section;
            var ii = block.querySelectorAll('.menu-item-row').length;
            var list = block.querySelector('.menu-items-list');
            var div = document.createElement('div');
            div.innerHTML = itemRowHtml(si, ii);
            list.appendChild(div.firstChild);
        }

        if (e.target.closest('.remove-item')) {
            e.target.closest('.menu-item-row').remove();
        }

        if (e.target.closest('.remove-section')) {
            e.target.closest('.menu-section-block').remove();
        }
    });
});
</script>
