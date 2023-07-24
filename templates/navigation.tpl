<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="/trang-chu">Home</a></li>
						<li><a href="/san-pham">Store</a></li>
						<li><a href="/contact">Contact</a></li>
						<li><a href="/news">News</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
<script>
// Lấy tất cả các liên kết trong menu
const links = document.querySelectorAll('ul li a');

// Lặp qua từng liên kết
links.forEach(link => {
  // Kiểm tra xem đường dẫn của liên kết có trùng với đường dẫn của trang hiện tại hay không
  if (link.getAttribute('href') === window.location.pathname) {
	console.log(window.location.pathname);
    // Nếu trùng, thêm class "active" vào thẻ <a>
    link.parentNode.classList.add('active');
  } else {
	link.parentNode.classList.remove('active');
  }
});
</script>