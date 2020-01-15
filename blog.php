<?php
	session_start();

    $title = "Blog | Emerdency – Emergency Dentist In Manchester ";
    $description = "This is the Emerdency Blog. Information and guidance on dental concerns, diseases, care and treatment in accordance with the latest research and guidelines. ";

	include ("header.php");
?>
<div class="main-content">
	<h1 class="page-title">Blog</h1>
	<div class="inner-row">
		<div class="article">
			<div class="col-33">
				<h2>Effective treatment options for broken and chipped teeth</h2>
				<div class="article-details">
					<span class="post-meta">09 November 2019</span>
				</div>
				<p>The frequency of chipped and broken teeth among dental patients have been increasing by the day. While the growing trend is rather peculiar, there is no denying that this matter is not to be ignored...  </p>
				<a class="btn-tel" href="effective-treatment-options-for-broken-and-chipped-teeth.php">Read more</a>
			</div>
			<div class="col-3">
				<img class="blog-thumb" src="images/blog/effective-tooth%20(1).JPG" alt="Dental care" height="250"/>
			</div>
		</div>
	</div>
</div>
<?php include( 'footer.php' ); ?>
