<!-- Modal Search -->
<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
    <div class="container-search-header">
        <button class="btn-hide-modal-search js-hide-modal-search">
            <img src="{{ asset('frontend/images/icons/icon-close2.png') }}" alt="CLOSE">
        </button>

        <h3 class="search-header-title">Search Products</h3>
        <p class="search-header-subtitle">Find exactly what you're looking for</p>

        <form class="wrap-search-header" id="search-form">
            <input class="search-input" type="text" name="search" id="search-input" placeholder="Type product name..."
                autocomplete="off">
            <button class="search-btn" type="submit">
                <i class="zmdi zmdi-search"></i>
            </button>
        </form>

        <div class="search-results-container" id="searchResults">
            <div class="search-no-results">Start typing to search for products...</div>
        </div>
    </div>
</div>

