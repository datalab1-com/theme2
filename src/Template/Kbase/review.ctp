<?php echo $this->Html->script('qna'); ?>

<!----------------------------------------------------------------------------->
<!-- SAVE THE QNA DATA: PHP to DOM to JAVASCRIPT -->
<!----------------------------------------------------------------------------->
<!-- load misc settings from php -->
<div class="data-misc" data-max="<?= $questionCount ?>" data-prompt="<?= $questionPrompt ?>"></div>

<!-- load each qna record from php -->
<?php $i = 0; foreach ($records as $rec) : ?>
	<div class="data-qna" data-question="<?php echo $rec['title']; ?>" data-answer="<?php echo $rec['description']; ?>"></div>
<?php endforeach; ?>

<!-- export the sql for the records -->
<!--

<?php $i = 0; foreach ($records as $rec) : ?>
	<?php echo 'INSERT INTO kbase (user_id, category_id, title, description) values (1, 42, "' . $rec['title'] . '", "' . $rec['description'] . '");'; ?>
<?php endforeach; ?>

-->

<!----------------------------------------------------------------------------->
<!-- SHOW QUESTIONS -->
<!----------------------------------------------------------------------------->

<?php if (count($records) == 0) : ?>

<?php else: ?>

<div style="margin-top: 0; padding-top: 0px;" class="kbase form-style-10-table">

<section class="quizSection" id="sectionStats">

	<!-------------------------------------------------------->
	<!-- STATS -->
	<!-------------------------------------------------------->
	<div>
		<span id="statsCount"></span>&nbsp;&nbsp;&nbsp;<span id="statsScore"></span>&nbsp;&nbsp;<span id="statsAlert"></span>
	</div>

	<!-------------------------------------------------------->
	<!-- DEBUG -->
	<!-------------------------------------------------------->
	
<?php if (isset($showDebug) && $showDebug) : ?>
	<div><span id="statsDebug"></span></div>
<?php else : ?>
	<div style="display: none;"><span id="statsDebug"></span></div>
<?php endif; ?>
	
</section>	

<section class="quizSection" id='sectionQna'>

	<!-------------------------------------------------------->
	<!-- QUESTION -->
	<!-------------------------------------------------------->
	<span id="question-graphics" style="background: white; font-size: 200%;">
		<img id="question-prompt" src="/img/question-prompt.jpg"/>
		<img id="question-right" src="/img/question-right.jpg"/>
		<img id="question-wrong" src="/img/question-wrong.jpg"/>
		<span id="promptQuestion"></span>&nbsp;<span id="prompt"><a onclick="quiz.start()">Click here to start</a></span>
	</span>
	
	<!-------------------------------------------------------->
	<!-- ANSWER -->
	<!-------------------------------------------------------->	
	<div class="kbase form">
		<?= $this->Form->create($kbase) ?>
		<fieldset id="runtimeFields">
		<div id="typeAnswers">
			<h4 style='margin: 0; margin-top: 10px; font-weight: normal;'><?= __('Type Answer:') ?></h4>
			
			<!-------------------------------------------------------->
			<!-- TEXTBOX TO ENTER ANSWER -->
			<!-------------------------------------------------------->
			<?php echo $this->Form->input('answer', ['onkeypress' => 'onKeypress(event)', 'id' => 'attempt', 'label' => '', 'style' => 'padding: 10px; border: 1px gray solid; font-size: 200%; width:100%;']); ?>
		</div>
			<!-------------------------------------------------------->
			<!-- SPACE TO SHOW SCORED ANSWER -->			
			<!-------------------------------------------------------->
			<div style="padding: 10px; font-size: 200%; min-height: 70px; background: #efefef; border: 1px gray solid; margin-top: 2px;" id="answer-show-div"></div>
			<?php //echo $this->Form->input('description', ['id' => 'answer-show', 'label' => '', 'style' => 'padding: 10px; border: 1px gray solid; font-size: 200%; width:100%;']); ?>

		</fieldset>

		<!-- BUTTONS ROW 1 -->
		
		<input class="btn btn-default" type="button" value="Next Question" onclick="nextAttempt()" id="button-next-attempt">
		<input class="btn btn-default" type="button" value="Check Answer" onclick="checkAnswer(1)" id="button-check-answer">
		<input class="btn btn-default" type="button" value="I KNOW IT" onclick="checkAnswer(2)" id="button-know" style="background-color: green; color: white;">
		<input class="btn btn-default" type="button" value="I DON'T KNOW" onclick="checkAnswer(3)" id="button-dont-know" style="background-color: red; color: white;">
		<input class="btn btn-default" type="button" value="START QUIZ" onclick="quiz.start()" id="button-start">
		<input class="btn btn-default" type="button" value="STOP QUIZ" onclick="resetQuiz()" id="button-stop">
		<input class="btn btn-default" type="button" onclick="override()" value="Change to Wrong" id="button-override">		
		<br/>
		
		<!-- BUTTONS ROW 2 -->
		
		<div id="buttonRowReview">
		<input class="btn btn-default" type="button" onclick="first()" value="<< First">
		<input class="btn btn-default" type="button" onclick="prev()" value="< Prev">
		<input class="btn btn-default" type="button" onclick="next()" value="Next >" id="button-next">
		<input class="btn btn-default" type="button" onclick="last()" value="Last >>">
		<input class="btn btn-default" type="button" value="Clear" onclick="clear2()">
		<br/>
		</div>
			
		<!-- CHECKBOX ROW -->
		
		<div style="margin-top: 10px">
			<?= $this->Form->checkbox('type-answers', ['id' => 'checkbox-type-answers', 'checked' => true, 'onclick' => 'quiz.typeAnswersClick()']) ?><span style='font-size: 100%; margin: 0 5px'>Type Answers</span>
			<?= $this->Form->checkbox('flip',         ['id' => 'checkbox-flip',         'checked' => false, 'onclick' => 'quiz.flip()']) ?><span style='margin: 0 5px'>Flip QnA</span>
			<?= $this->Form->checkbox('show-answers', ['id' => 'checkbox-show',         'checked' => false, 'onclick' => 'quiz.showAnswersClick()']) ?><span style='margin: 0 5px'>Show Answers</span>
		</div>
		
		<?= $this->Form->end() ?>
	</div>
	
</section>

<!----------------------------------------------------------------------------->
<!-- CONTROL BUTTONS -->
<!----------------------------------------------------------------------------->

	<div style='margin-top: 10px;'>
	</div>

</div>

<?php endif; ?>
