<?php
	session_start();

    $title = "Blog | Emerdency – Emergency Dentist In Manchester ";
    $description = "This is the Emerdency Blog. Information and guidance on dental concerns, diseases, care and treatment in accordance with the latest research and guidelines. ";

	include ("header.php");
?>
<div class="main-content">
<div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
    <h1 class="page-title">Blog</h1>
</div>
	
	<div class="col-md-8 col-md-offset-2 bg-dark" style="padding:50px;border-radius:20px;">
		<div class="article" style="">
		<div class="col-md-6">
	<img class="blog-thumb img-responsive" src="images/blog/effective-tooth%20(1).JPG" alt="Dental care"  height="250"/>
			</div>
			<div class="col-md-6">
				<h2 style="color:#E9531D">Effective treatment options for broken and chipped teeth</h2>
				<div class="article-details" style="padding-top:20px;">
					<span class="post-meta pull-right" style="color:white;">09 November 2019</span>
					<br><br>
				</div>
				<p style="color:grey; padding:10px; " align="justify">The frequency of chipped and broken teeth among dental patients have been increasing by the day. While the growing trend is rather peculiar, there is no denying that this matter is not to be ignored...  </p>
		       <div class="col-md-3" style="margin-bottom:30px;">
				<a class="btn" href="effective-treatment-options-for-broken-and-chipped-teeth.php">Read more</a>
		       </div>
			</div>
			
		</div>
	</div>
</div>
<?php include( 'footer.php' ); ?>
