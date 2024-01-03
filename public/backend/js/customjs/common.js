$('body').on('change', '.breadcrumb-branch', function(){
    document.cookie = "branch="+$(this).val();
    location.reload();
});
