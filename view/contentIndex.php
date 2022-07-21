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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete branches ID - <span class="branch_id"></span>?</h5>
                    <button type="button" class="close_delete" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <div class="timer btn btn-primary">30</div>
                    <a type="button" class="btn btn-success close_delete" data-dismiss="modal" aria-hidden="true">Close</a>
                    <button type="button" class="btn btn-danger apply_delete">Deleted</button>
                </div>
            </div>
        </div>
    </div>
<script>

    let contentHtml = '';
    let nextLvl = true;
    let appendHtml = '';
    let allParents = [];
    let delModal = $('#deleteModal');

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
        let thisBrances =$(this).parent();
        let title = '123';
        let style = '';
        let newParent = '';
        let lastId
        $.ajax({
            url: 'addnewbranches',
            method: 'POST',
            data: {
                parent: parent,
                title: title
            },
            success: function (result){
                lastId = $.parseJSON(result);
                if(thisBrances.parent().hasClass('closed')){
                    style = 'style="height: 0px;"';
                }
                appendHtml += '<div class="list-group-item" '+style+'>';
                appendHtml += '<p>'+title+'<span class="add_branches" data-branchesid='+lastId.id+'>+</span><span class="remove_branches" data-branchesid='+lastId.id+'>-</span></p>';
                appendHtml += '</div>';
                thisBrances.parent().append(appendHtml);
                if(!thisBrances.find('span').hasClass('arrow')){
                    newParent = '<span class="arrow">&darr;</span>'+thisBrances.html();
                    thisBrances.html(newParent);
                }
                appendHtml = '';
            }
        });
    });

    $('body').on('click', '.close_delete', function (){
        $('.clicked').removeClass('clicked');
        delModal.modal('hide');
        $('.timer').text(30);
    });

    function startTimer(){
        let seconds = 30;
        let int;
        int = setInterval(function() {
            if (seconds > 0) {
                if(delModal.is(':visible')){
                    seconds--;
                    $('.timer').text(seconds);
                } else {
                    clearInterval(int);
                    seconds = 30;
                }
            } else {
                clearInterval(int);
                seconds = 30;
                delModal.modal('hide');
                $('.clicked').removeClass('clicked');
            }
        }, 1000);
    }

    $('.list-group').on('click', '.list-group-item p .remove_branches',function (e) {
        e.stopPropagation();
        $(this).parent().parent().addClass('clicked');
        delModal.find('.branch_id').text($(this).data('branchesid'));
        delModal.find('.apply_delete').attr('data-delete', $(this).data('branchesid'));
        delModal.modal('show');
        startTimer();
    });

    $('body').on('click','.apply_delete', function(e){
        e.stopPropagation();
        let id = $(this).data('delete');
        $.ajax({
            url: 'delnewbranches',
            method: 'POST',
            data: {
                id: id
            },
            success: function (result) {
                let delResult = $.parseJSON(result);
                if(delResult.result){
                    delModal.modal('hide');
                    let old = $('.clicked').parent();
                    $('.clicked').remove();
                    if(old.find('div').length === 0){
                        old.find('.arrow').remove();
                    }
                }
            }
        });
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