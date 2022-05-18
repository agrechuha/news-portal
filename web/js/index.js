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

    $('.buttons-kinds .btn').on('click', function (e) {
        let $this = $(this);
        let categoryName = $this.data('category');

        $('.buttons-kinds .btn').removeClass('active');
        $this.addClass('active');

        let url = categoryName ? '/category/' + categoryName :  '/';
        if (dateSortVal) {
            url += '?date-sort=' + dateSortVal;
        }
        $.pjax.reload({
            container: '#news-pjax',
            type: 'GET',
            url,
        });
    })
})