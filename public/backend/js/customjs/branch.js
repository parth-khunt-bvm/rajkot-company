var Branch = function(){
    var list = function(){
        alert('list');
    }
    var addBranch = function(){
        alert('addBranch');
    }
    var editBranch = function(){
        alert('editBranch');
    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addBranch();
        },
        edit:function(){
            editBranch();
        }
    }
}();
