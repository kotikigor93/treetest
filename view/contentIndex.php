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
        <div class="row">
            <div class="main_body col-6">
                <h2>MY <span class="title_color">TEST TREE</span></h2>
                <div class="list-group list-group-checkable">
                </div>
            </div>
        </div>
        <div class="row <?= !$data['active_root_create'] ? 'hidden' : ''?>">
            <div class="btn_create">
                <a href="#" class="btn btn-secondary text-white" id="create_root">Create Root</a>
            </div>
        </div>
    </div>
</div>
<script>

    let contentHtml = '';
    let nextLvl = true;
    let appendHtml = '';
    let allParents = [];

    $('#create_root').click(function (){
        $.ajax({
            url: 'create/main',
            method: 'POST',
            data: {
                parent: 0
            },
            success: function (result){
                loadTree();
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
                if(branchList.length > 0){
                    $('#create_root').hide();
                }
                createTree(branchList);
                $('.main_body .list-group').html(contentHtml);
            }
        })
    }

    function createTree(branchList){
        getAllParents(branchList);
        $.each(branchList, function (index, objMain){
            if(nextLvl){
                contentHtml += '<div class="list-group-item">';
                contentHtml += '<p><span class="arrow">&darr;</span>'+objMain.title+'<span class="add_branches" data-branchesid='+objMain.id+'>+</span><span class="remove_branches" data-branchesid='+objMain.id+'>-</span></p>';
                createTreeBranches(branchList,objMain);
                contentHtml += '</div>';
            }
            nextLvl = false;
        })

    }

    function getAllParents(branchList){
        $.each(branchList, function (index, obj){
            if(!allParents.includes(obj.parent)){
                allParents.push(obj.parent);
            }
        });
    }

    function createTreeBranches(branchList, curentObj){
        if(nextLvl){
            $.each(branchList, function (index, obj){
               if(curentObj.id === obj.parent){
                   let arrow = '';
                   if(allParents.includes(obj.id)){
                       arrow = '<span class="arrow">&darr;</span>';
                   }
                   contentHtml += '<div class="list-group-item">';
                   contentHtml += '<p>'+arrow+obj.title+'<span class="add_branches" data-branchesid='+obj.id+'>+</span><span class="remove_branches" data-branchesid='+obj.id+'>-</span></p>';
                   createTreeBranches(branchList, obj);
                   contentHtml += '</div>';
               } else {
                   nextLvl = true;
               }
            });
        }
    }

    $('.list-group').on('click', '.list-group-item p .add_branches',function (e){
        e.stopPropagation();
        let parent = $(this).data('branchesid');
        let title = '123';
        let appendid = 0;
        let style = '';
        let newParent = '';
        $.ajax({
            url: 'addnewbranches',
            method: 'POST',
            data: {
                parent: parent,
                title: title
            },
            success: function (result){
                let lastId = $.parseJSON(result);
                appendid = lastId.id;
            }
        });
        if($(this).parent().parent().hasClass('closed')){
            style = 'style="height: 0px;"';
        }
        appendHtml += '<div class="list-group-item" '+style+'>';
        appendHtml += '<p>'+title+'<span class="add_branches" data-branchesid='+appendid+'>+</span><span class="remove_branches" data-branchesid='+appendid+'>-</span></p>';
        appendHtml += '</div>';
        $(this).parent().parent().append(appendHtml);
        if(!$(this).parent().find('span').hasClass('arrow')){
            newParent = '<span class="arrow">&darr;</span>'+$(this).parent().html();
            $(this).parent().html(newParent);
        }
        appendHtml = '';
    });

    $('.list-group').on('click','.list-group-item p', function(e){
        $(this).parent().toggleClass('closed');
        if($(this).parent().hasClass('closed')){
            $(this).find('.arrow').html('&rarr;');
        } else {
            $(this).find('.arrow').html('&darr;');
        }
        $.each($(this).parent().children(), function (index, block){
            if(block.tagName === 'DIV'){
                if (block.style.height === "0px") {
                    block.style.height = `${ block.scrollHeight }px`;
                } else {
                    block.style.height = `${ block.scrollHeight }px`;
                    window.getComputedStyle(block, null).getPropertyValue("height");
                    block.style.height = "0";
                }
                block.addEventListener("transitionend", () => {
                    if (block.style.height !== "0px") {
                        block.style.height = "auto"
                    }
                });
            }
        });
    });

    $(document).ready(function (){
        loadTree();
    })
</script>
<?php
require_once 'view/footer.php';
?>