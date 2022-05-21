$(document).ready(function () {
    let dateSortSelect = $('#date-sort');
    let dateSortVal = window.dateSort;

    dateSortSelect.on('input', function (e) {
        dateSortVal = $(this).val();

        $.pjax.reload({
            container: '#news-pjax',
            type: 'GET',
            url: window.location.pathname + '?date-sort=' + dateSortVal,
        });
    });

    $('.category-menu-link').on('click', function (e) {
        let $this = $(this);
        let categoryName = $this.data('category');

        let url = categoryName ? '/category/' + categoryName :  '/';
        if (dateSortVal) {
            url += '?date-sort=' + dateSortVal;
        }
        $.pjax.reload({
            container: '#news-pjax',
            type: 'GET',
            url,
        });
        return e.preventDefault();
    })
})