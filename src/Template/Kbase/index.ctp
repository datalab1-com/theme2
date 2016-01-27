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

<div class="kbase form-style-10-table">
    <h3><?= __($title) ?></h3>
	<?php $cnt = 0; foreach ($records as $rec): ?>	
		<div>
			<table style=''>
				<tr style="cursor: pointer;" onclick="faqshow(<?php echo $cnt; ?>)">
					<th>
						<a href="#">
							<span style="font-size: 120%;">
								&nbsp;<span style="font-family: Courier New;" class="faqplusclass" id="faqplus<?php echo $cnt; ?>">+</span>&nbsp;<?= h($rec->title) ?>
							</span>
						</a>
					</th>
				</tr>
				<tr class="faqclass" id="faqid<?php echo $cnt++; ?>" style="display: none; border: 1px dotted #A4CC58;">
					<td style=""> 
				        <!-- ?= $this->Text->autoParagraph(h($rec->description)); ? -->
						<?php echo $this->Custom->cmsFormat($rec->description); ?>
					</td>
				</tr>
			</table>
		</div>
    <?php endforeach; ?>
 
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
