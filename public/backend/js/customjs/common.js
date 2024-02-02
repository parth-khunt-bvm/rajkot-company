$('body').on('change', '.breadcrumb-branch', function(){
    // document.cookie = "branch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "branch="+$(this).val();
    location.reload();
});
