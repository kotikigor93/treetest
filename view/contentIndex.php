<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:19
 */

require_once 'view/header.php';

?>
<div class="main_content">
    <div class="container">
        <div class="row <?= !$data['active_root_create'] ? 'hidden' : ''?>">
            <div class="btn_create">
                <a href="#" class="btn btn-secondary text-white" id="create_root">Create Root</a>
            </div>
        </div>
        <div class="row">
            <div class="main_body col-3">
                <div class="list-group list-group-checkable">
                    <div class="list-group-item">
                        <h5>ROOT</h5>
                        <div class="list-group-item">
                            <h5>SUB ROOT 1</h5>
                            <div class="list-group-item">
                                <h5> SUB ROOT 1 1</h5>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <h5>SUB ROOT 2</h5>
                        </div><div class="list-group-item">
                            <h5>SUB ROOT 3</h5>
                        </div><div class="list-group-item">
                            <h5>SUB ROOT 4</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>

    let contentHtml = '';
    let parentList = [];
    let nextLvl = true;

    $('#create_root').click(function (){
        $.ajax({
            url: 'create/main',
            method: 'POST',
            data: {
                id: 1
            },
            success: function (result){
                //creator
            }
        })
    });

    function loadTree(){
        let branchList = '';
        $.ajax({
            url: 'getbrancheslist',
            method: 'POST',
            success: function (result){
                branchList = $.parseJSON(result);
                createTree(branchList);
                $('.main_body .list-group').html(contentHtml);
            }
        })
    }

    function createTree(branchList){
        $.each(branchList, function (index, objMain){
            if(nextLvl){
                contentHtml += '<div class="list-group-item">';
                contentHtml += '<h4>'+objMain.title+'</h4>';
                createTreeBranches(branchList,objMain);
                contentHtml += '</div>';
            }
            nextLvl = false;
        })

    }

    function createTreeBranches(branchList, curentObj){
        if(nextLvl){
            $.each(branchList, function (index, obj){
               if(curentObj.id === obj.parent){
                   contentHtml += '<div class="list-group-item">';
                   contentHtml += '<h4>'+obj.title+'</h4>';
                   createTreeBranches(branchList, obj);
                   contentHtml += '</div>';
               } else {
                   nextLvl = true;
               }
            });
        }
    }

    function getMaxSubLvl(list){
        $.each(list, function (index, obj) {
            if(!parentList.includes(obj.parent)){
                parentList.push(obj.parent);
            }
        });
        return parentList.length;
    }

    $(document).ready(function (){
        loadTree();
    })
</script>
<?php
require_once 'view/footer.php';
?>