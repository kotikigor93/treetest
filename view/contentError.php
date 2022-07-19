<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:21
 */

require_once $data['view_header'];
?>

<div class="content">
    <div class="body_content">
        ERROR 404, PAGE NOT FOUND!
    </div>
</div>
<style>
    body{
        margin: 0 auto;
    }
    .content{
        height: 100vh;
        width: 100vw;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        background: #eee;
    }
    .body_content{
        padding: 20px;
        border: 3px solid red;
        font-size: 20px;
        font-weight: 900;
        color: red;
        box-shadow: 10px 10px 10px 0;
    }
</style>

<?php
require_once $data['view_footer'];
?>
