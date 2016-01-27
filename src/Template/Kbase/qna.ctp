<script>

function faqshow1(id)
{
	$(".faqclass").hide();	
	$("#faqid" + id).show();
}

function faqshow(id)
{
	var visible = false;
	var eid = "#faqid" + id;
	
	if ($(eid).is(":visible"))
	{
		visible = true;
	}

	$(".faqclass").hide();
	$(".faqplusclass").text("+");
	
	if (!visible)
	{
		$("#faqplus" + id).text("-");
		$(eid).show();
	}
}

</script>
<div style="" id="" class="container">

<?php
	$cnt = 0; 
	$canEdit = false;
	$catName = 'Entries';
?>

<!----------------------------------------------------------------------------->
<!-- SHOW CATEGORY MENU AT THE TOP -->
<!----------------------------------------------------------------------------->
<div style='margin-top: 20px;'>		
	<?php if (isset($categories)) : ?>
		<?php foreach ($categories as $cat) : ?>
			<?php if (intval($cat['total_questions']) > 0) : ?>

				<span style="" class="label label-faq <?php echo (($cat['nickname'] == $activeCategory) ? ' label-faq-active ' : '')?> />">
					<a href='/kbase/<?= $activeUrl ?>/<?= $cat['nickname'] ?>'>
						<?= $cat['name'] ?>
						<span style="" class="badge badge-faq 
						<?php 
							if ($cat['nickname'] == $activeCategory)
							{
								$catName = $cat['name'];
							}
							
							echo (($cat['nickname'] == $activeCategory) ? 'badge-faq-active' : '');
						?>"><?= $cat['total_questions'] ?></span>
						
					</a>					
				</span>
				
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<!-- IF USER LOGGED-IN, SHOW EXTRA BUTTON -->

	<?php if ($isLoggedIn) : ?>
		<?php $url = '/kbase/add/' . $categoryId; ?>
		<button style="background-color: blue;" class="label label-faq" onclick="location.href='<?= $url ?>'">
			<a href="<?= $url ?>">Add</a>
		</button>
	<?php endif; ?>
	
</div>

<!----------------------------------------------------------------------------->
<!-- SHOW QUESTIONS -->
<!----------------------------------------------------------------------------->

<h1><?= $catName ?></h1>

<?php foreach($records as $rec) : ?>
	<div style="margin: 10px 0; background-color: <?php echo (($cnt % 2 == 0) ? '#FEFEE3' : 'white'); ?>; border: lightGray solid 1px">
		<div style="border-bottom: lightGray dashed 1px; padding: 5px; font-size: 130%; min-width: 200px; margin: 20px; padding-bottom: 20px;">
			<?= ++$cnt . '. &nbsp;' . $rec['title'] ?>
			<?php if ($canEdit) : ?>
				<span style='font-size: 70%; float: right;'>
					<a href=<?= '/kbase/edit/' . $rec['id'] ?> >Edit</a>
					&nbsp;&nbsp;
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rec['id']], ['confirm' => __('Are you sure you want to delete: {0}?', $rec['title'])]) ?>
				</span>
			<?php endif; ?>			
		</div>
		<div class="faqclass" style="padding: 5px; font-size: 120%; min-width: 200px; margin: 20px; xmargin-right: 20px;">
			<!-- ?= $rec['description'] ? -->
			<?php echo $this->Custom->cmsFormat($rec->description); ?>
			
		</div>
	</div>
<?php endforeach; ?>

</div><!-- container -->