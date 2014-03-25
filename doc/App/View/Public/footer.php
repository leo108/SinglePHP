<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/holder/2.0/holder.min.js"></script>
<script src="http://cdn.bootcss.com/highlight.js/7.3/highlight.min.js"></script>
<script >hljs.initHighlightingOnLoad();</script>
<script src="http://v3.bootcss.com/docs-assets/js/application.js"></script>
<?php if(isset($js)) foreach($js as $path){
    echo "<script src='$path'></script>";
}
?>
</body>
</html>
