<li class="nav-item">
    <a style="color: rgba(0, 0, 0, 0.5);padding-left: 1rem;padding-right: 1rem;    position: relative;
    height: 2.5rem;display: block;
    padding: 0.5rem 1rem;"
       data-msg="确定要退出吗?"
       onclick="logout()"
       href="javascript:;">
        <i class="fa fa-power-off" ></i>
    </a>
</li>
<script>

    function logout() {
        if (confirm("您确定要退出吗？"))
        {
            window.location.href = "?app=user@logout&_vendor=1";
        }
    }

</script>