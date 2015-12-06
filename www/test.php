<html>
<head>
<link rel="stylesheet" href="slickNav/style.css">
<link rel="stylesheet" href="slickNav/slicknav.css" />
<script src="slickNav/jquery.slicknav.min.js"></script>
<script src="slickNav/jquery.slicknav.js"></script>
<script src="js/jquery-1.11.3.min.js"></script>
</head>
<ul id="menu2">
    <li>Parent 1
        <ul>
            <li><a href="#">item 3</a></li>
            <li>Parent 3
                <ul>
                    <li><a href="#">item 8</a></li>
                    <li><a href="#">item 9</a></li>
                    <li><a href="#">item 10</a></li>
                </ul>
            </li>
            <li><a href="#">item 4</a></li>
        </ul>
    </li>
    <li><a href="#">item 1</a></li>
    <li>non-link item</li>
    <li>Parent 2
        <ul>
            <li><a href="#">item 5</a></li>
            <li><a href="#">item 6</a></li>
            <li><a href="#">item 7</a></li>
        </ul>
    </li>
</ul>
<script type="text/javascript">
$('#menu2').slicknav({
        label: '',
        duration: 1000,
        easingOpen: "easeOutBounce", //available with jQuery UI
        prependTo:'#menu2'
});

</script>
</body>
</html>
