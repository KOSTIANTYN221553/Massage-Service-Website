<?php echo e(getCurrentLang()); ?>

<?php if(isset($pageParam)): ?>
<style>
    .pagination{
        margin: 0px auto;
    }
    .pagination ul > li > a, .pager > li > a, .pagination ul > li > span, .pager > li > span {
        border-width: 1px;
        border-radius: 0 !important
    }

    .pagination ul > li > a, .pager > li > a {
        color: #2283c5;
        background-color: #fafafa;
        margin: 0 -1px 0 0;
        border-color: #e0e8eb
    }

    .pagination ul > li > a:hover, .pager > li > a:hover {
        background-color: #6c757d	;
    }

    .pagination ul > li.disabled > a, .pagination ul > li.disabled > a:hover, .pager > li.disabled > a, .pager > li.disabled > a:hover {
        background-color: #f9f9f9;
        border-color: #d9d9d9
    }

    .pagination ul > li > a.active, .pagination ul > li > a.active {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25)
    }
    .pagination ul>li>a, .pagination ul>li>span {
        float: left;
        padding: 4px 12px;
        line-height: 20px;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
</style>
<?php if($pageParam['startStep']+10 > $pageParam['pageCount'] || $pageParam['startStep']+10 == $pageParam['pageCount']): ?>
    <?php $endPage = $pageParam['pageCount']-$pageParam['startStep'];?>
<?php endif; ?>
<?php
    if($pageParam['startStep']+10 < $pageParam['pageCount']){
        $endPage = 10;
    }
?>



<?php if($pageParam['pageCount']*1 > 1): ?>
    <div class="dataTables_paginate paging_bootstrap pagination" style = "text-align:center;">
        <ul class="pagination">
            <li>
                <?php if($pageParam['startStep']*1 < 10): ?>
                    <span disabled><i class = "fa fa-angle-double-left cursor"></i></span>
                <?php endif; ?>
                <?php if(($pageParam['startStep']*1 > 10) || ($pageParam['startStep']*1 == 10)): ?>
                    <a href="javascript:void(0);" onclick = "searchData(1);"><i class = "fa fa-angle-double-left cursor"></i></a>
                <?php endif; ?>
            </li>
            <li>
                <?php if($pageParam['startStep']*1 == 0): ?>
                    <span disabled><i class = "fa fa-angle-left cursor"></i></span>
                <?php endif; ?>
                <?php if(($pageParam['startStep']*1 > 10) || ($pageParam['startStep']*1 == 10)): ?>
                    <a href="javascript:void(0);" onclick = "searchData('<?php echo e($pageParam['pageNo']-10+1); ?>')"><i class = "fa fa-angle-left cursor" ></i></a>
                <?php endif; ?>
            </li>
            <?php for($i=1; $i<=$endPage; $i++): ?>
                <?php if($pageParam['pageNo']*1==($pageParam['startStep']*1+$i*1)): ?>
                    <li><a href="javascript:void(0)" onclick = "searchData('<?php echo e($pageParam['startStep']+$i); ?>')"  class="active"><?php echo e($pageParam['startStep']+$i); ?></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0)" onclick = "searchData('<?php echo e($pageParam['startStep']+$i); ?>')"><?php echo e($pageParam['startStep']+$i); ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <li>
                <?php if(($pageParam['pageCount']-$pageParam['startStep'] < 10) || ($pageParam['pageCount']-$pageParam['startStep']  == 10)): ?>
                    <span disabled><i class = "fa fa-angle-right cursor"></i></span>
                <?php endif; ?>
                <?php if($pageParam['pageCount']-$pageParam['startStep'] > 10): ?>
                    <a href="javascript:void(0)" onclick = "searchData('<?php echo e($pageParam['startStep']+10+1); ?>')"><i class = "fa fa-angle-right cursor"></i></a>
                <?php endif; ?>
            </li>
            <li>
                <?php if($pageParam['pageNo'] == $pageParam['pageCount']): ?>
                    <span disabled><i class = "fa fa-angle-double-right cursor"></i></span>
                <?php endif; ?>
                <?php if($pageParam['pageCount'] - $pageParam['pageNo'] > 0): ?>
                    <a href="javascript:void(0)" onclick = "searchData('<?php echo e($pageParam['pageCount']); ?>')"><i class = "fa fa-angle-double-right cursor"></i></a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
<?php endif; ?>

<script type="text/javascript">
    <?php if(!isset($searchFun)): ?>
    function searchData(page) {
        $("#searchForm input[name='page']").val(page);
        $("#searchForm").submit();
    }
    <?php else: ?>
    function searchData(page) {
        var cmd = "<?php echo e($searchFun); ?>("+page+")";
        eval(cmd);
    }
    <?php endif; ?>
</script>
<?php endif; ?>