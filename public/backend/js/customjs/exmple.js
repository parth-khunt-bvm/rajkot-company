var Exmple = function(){
    var list = function(){
        alert('list');
    }
    var addExmple = function(){
        alert('addExmple');
    }
    var editExmple = function(){
        alert('editExmple');
    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addExmple();
        },
        edit:function(){
            editExmple();
        }
    }
}();
