$(document).ready(function () {
    paginationInit();
});

var paginationInit = function () {
    $('#contactPagination li a').bind('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var target = $this.attr('id');
        var $currentItem = $('#contactPagination a.active').parents('li');
        var $contactGrid = $('#contactGrid');
        switch (target) {
            default:
                $('#contactPagination a').removeClass('active');
                $this.addClass('active');
                var page = target;
                $.get('contacts.php', {'page': page}, function (data) {
                    $contactGrid.html(data);
                });
                break;
            case 'next':
                var $nextItem = $currentItem.next('li');
                $('#contactPagination a').removeClass('active');
                var $pageToActive = $nextItem.find('a').addClass('active');
                var page = $pageToActive.attr('id');
                $.get('contacts.php', {'page': page}, function (data) {
                    $contactGrid.html(data);
                });
                break;
            case 'previous':
                var $previousItem = $currentItem.prev('li');
                $('#contactPagination a').removeClass('active');
                var $pageToActive = $previousItem.find('a').addClass('active');
                var page = $pageToActive.attr('id');
                $.get('contacts.php', {'page': page}, function (data) {
                    $contactGrid.html(data);
                });
                break;
        }
        hidePreviousNextButtons();
    });
}
var hidePreviousNextButtons = function () {
    var $currentItem = $('#contactPagination a.active');
    var currentItemID = $currentItem.attr('id');
    var $nextButton = $('#contactPagination #next');
    var $previousButton = $('#contactPagination #previous');
    var lastItemID = $nextButton.parents('li').prev('li').find('a').attr('id');
    var firstItemID = $previousButton.parents('li').next('li').find('a').attr('id');
    currentItemID == lastItemID ? $nextButton.hide() : $nextButton.show();
    currentItemID == firstItemID ? $previousButton.hide() : $previousButton.show();
}