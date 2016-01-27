//-----------------------------------------------------------------------------
// THE QNA JS APPLICATION 
//-----------------------------------------------------------------------------

//
// Constants
//
const RUNSTATE_START = 1;
const RUNSTATE_ASKING = 2;
const RUNSTATE_CHECKING = 3;

const CHECKANSWER_NORMAL = 1;
const CHECKANSWER_KNOW = 2;
const CHECKANSWER_DONTKNOW = 3;

const SCORE_NOTSET = 0;
const SCORE_CORRECT = 1;
const SCORE_WRONG = 2;

const OVERRIDE_RIGHT = "Change to Correct";
const OVERRIDE_WRONG = "Change to Wrong";

$( document ).ready(function() {
	$("#checkbox-type-answers").prop('checked', !isMobile.any());
	quiz.setButtonStates(RUNSTATE_START);
	quiz.setControlStates();
	loadData();
	loadOrder();	
	quiz.showAnswersClick();
	quiz.typeAnswersClick();
	
});

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

//
// quiz class
//
function quiz() {

	this.questions = [];
	this.answers = [];
	this.correct = [];
	this.order = [];
	
	// options
	this._flip = false;
	this.promptQuestion = ''; // loaded after ready
	this.lastScore = SCORE_NOTSET;
	this.runState = RUNSTATE_START;
	
	this.question = function(index) {
		return this.questions[this.order[index]];
	}
	
	this.setControlStates = function() {
		$("#button-start").focus();			
	}

	this.setButtonStates = function(state) {

		var typeAnswers = $("#checkbox-type-answers").prop('checked');
		
		this.runState = state;
		
		if (state == RUNSTATE_START)
		{
			//
			// only show the start button
			//
			quiz.showOverrideButton(false, null);
			$("#button-check-answer").hide();
			$("#button-next-attempt").hide();
			$("#button-know").hide();
			$("#button-dont-know").hide();

			$("#button-start").show();
			$("#button-stop").hide();

			$("#question-right").hide();
			$("#question-wrong").hide();
			$("#question-prompt").hide();
		}
		else if (state == RUNSTATE_ASKING)
		{
			//
			// asking the question
			//
			if (typeAnswers)
			{
				$("#button-check-answer").show();
				$("#button-know").hide();
				$("#button-dont-know").hide();
			}
			else
			{
				$("#button-know").show();
				$("#button-know").focus();
				$("#button-dont-know").show();
				$("#button-check-answer").hide();
			}
			
			quiz.showOverrideButton(false, null);
			$("#button-next-attempt").hide();
			$("#button-start").hide();
			$("#button-stop").show();

			$("#question-right").hide();
			$("#question-wrong").hide();
			$("#question-prompt").show();
		}
		else if (state == RUNSTATE_CHECKING)
		{
			$("#question-prompt").hide();
			
			//
			// checking the answer
			//
			if (typeAnswers)
			{
				$("#button-check-answer").show();
				$("#button-know").hide();
				$("#button-dont-know").hide();
			}
			else
			{
				$("#button-check-answer").hide();
				$("#button-know").hide();
				$("#button-dont-know").hide();
			}
			
			quiz.showOverrideButton(true, null);
			$("#button-next-attempt").show();
			$("#button-start").hide();
			$("#button-stop").show();
		}
		else
		{
			alert("setButtonStates - bad value");
		}
	}	
	
	this.flipped = function() {
		return this._flip;
	}
	
	this.flip = function() {
		this._flip = !this._flip;
		this.promptQuestion = (this._flip ? 'country for this capital:' : 'what is the capital of');
		this.showQuestion();	
	}
	
	this.start = function() {
		resetQuiz();
		this.showQuestion();
		nbr = 1;
		updateScore();
		
		this.setButtonStates(RUNSTATE_ASKING);		
	}
	
	this.showQuestion = function() {	
		clear();
		
		// show question
		var q = getQuestion(true);
		$("#prompt").text(q);
		
		// show answer
		if ($("#checkbox-type-answers").prop('checked'))
		{
			var a = getQuestion(false);
			$("#answer-show").text(a);
			$("#answer-show").val(a);
		}

		// show prompt
		$("#promptQuestion").text(quiz.promptQuestion);
		
		var typeAnswers = $("#checkbox-type-answers").prop('checked');
		if (typeAnswers)
		{
			$("#attempt").focus();	
		}
		else
		{
			$("#button-know").focus();	
		}
	}

	this.showOverrideButton = function(show, label)
	{
		$("#button-override").prop('disabled', !show);
		
		if (label != null)
			$("#button-override").val(label);
		
		if (!show)
		{
			$("#button-override").hide();
			$("#button-override").css('background-color', 'white');
		}
		else
		{
			$("#button-override").show();
			$("#button-override").css('background-color', 'yellow');
		}
	}

	this.typeAnswersClick = function()
	{
		this.setButtonStates(this.runState);
		
		var typeAnswers = $("#checkbox-type-answers").prop('checked');

		if (typeAnswers)
		{
			$("#typeAnswers").css('display', 'default');
		}
		else
		{
			$("#typeAnswers").css('display', 'none');
		}
	}	
	
	this.showAnswersClick = function() {

		var showAnswers = $("#checkbox-show").prop('checked');
		var answer = '';
		if (showAnswers)
		{
			$("#buttonRowReview").css('display', 'default');
			answer = getAnswer();
		}
		else
		{
			$("#buttonRowReview").css('display', 'none');		
		}
			
		$("#answer-show").val(answer);
		$("#answer-show").text(answer);	
	}
	
}

var quiz = new quiz();

//
// numbers
//
var wrong = 0;
var right = 0;
var round = 1;
var curr = 0;
var nbr = 0;

//
// max number of qna
//
var max = 0;
var statsMax = 0;

function loadData()
{
	//
	// load qna arrays
	//
	var i = 0;
	$('.data-qna').each(function() {
        var container = $(this);
        var service = container.data('title');

		quiz.questions[i] = container.data('question');
		quiz.answers[i] = container.data('answer');
		quiz.correct[i] = false;
		
		//if (i == 0) alert(quiz.questions[i]);
			
		i++;		
    });
	
	//
	// load misc variables
	//
	$('.data-misc').each(function() {
        var container = $(this);

		max = container.data('max');
		quiz.promptQuestion = container.data('prompt');
		
		if (i == 0)
			alert(quiz.questions[i]);
			
		i++;		
    });
	
	statsMax = max;
	//alert("max=" + max + ", prompt=" + quiz.promptQuestion);
}

function loadOrder() 
{
	// load random map
	for (var i = 0; i < max; i++)
		quiz.order[i] = i;
		
	quiz.order = shuffle(quiz.order);
	
	/*
	var s = "";
	for (var i = 0; i < max; i++)
		s += quiz.order[i] + ",";
	alert(s);	
	*/
}

function shuffle(array) 
{
	var currentIndex = array.length, temporaryValue, randomIndex ;

	// While there are elements to shuffle...
	while (0 !== currentIndex) 
	{
		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}

	return array;
}

function first()
{
	curr = 0;
	loadQuestion();
}

function last()
{
	curr = max - 1;	
	loadQuestion();
}

function next()
{
	curr++;
	if (curr >= max)
	{
		curr = 0;
		nbr = 0;
	}
	
	loadQuestion();
}

function nextAttempt()
{
	quiz.setButtonStates(RUNSTATE_ASKING);
	
	var done = false;
	var count = 0;
	while(!done)
	{
		curr++;
		
		// check if at the end of round
		if (curr >= max)
		{
			curr = 0;
			nbr = 0;
			score = (right / (right+wrong)) * 100;
			alert('End of Round ' + round + ': ' + score.toFixed(2) + '% (' + right + ' of ' + (right+wrong) + ')');		
			round++;
			statsMax = wrong;
			right = 0;
			wrong = 0;
		}
		
		// if question not answered correctly yet
		if (!quiz.correct[quiz.order[curr]])
		{
			loadQuestion();
			done = true;
		}	
		else if (count++ >= max)
		{					
			// no wrong answers left
			alert('Done, all answered correctly!!');
			resetQuiz();
			done = true;
		}

		if (count > 10000)
		{
			// break out just in care we're looping
			break;
		}
	}	
}

function prev()
{
	curr--;
	if (curr < 0)
		curr = max - 1;
	
	loadQuestion();
}

function resetQuiz()
{
	clear();
	quiz.setButtonStates(RUNSTATE_START);

	for (var i = 0; i < max; i++)
		quiz.correct[i] = false;

	curr = 0;
	right = 0;
	wrong = 0;
	round = 1;
	statsMax = max;
	nbr = 0;
	
	loadOrder();
}

function clear2()
{
	clear();
}

function clear()
{
	$("#attempt").val('');
	$("#attempt").text('');
	
	$("#answer-show").val('');
	$("#answer-show").text('');
	
	$("#answer-show-div").text('');
}

function getAnswer()
{	
	return getQuestion(false);
}

function getQuestion(question)
{	
	var q = null;
	var flip = (question) ? quiz.flipped() : !quiz.flipped(); // flip the flip for getting answers!!
	
	if (flip)
		q = quiz.answers[quiz.order[curr]];
	else
		q = quiz.questions[quiz.order[curr]];

	return q;
}

function loadQuestion()
{	
	quiz.showQuestion();
	nbr++;
	updateScore();
}

function toStringBoolArray(a)
{
	var s = '';
	
	for (var i = 0; i < a.length; i++)
	{
		s += (a[i] ? "1" : "0");
	}
	
	return s;
}

function onKeypress(e)
{
	if (e.keyCode == 13)
	{
		e.stopImmediatePropagation();
		e.preventDefault();
		checkAnswer(CHECKANSWER_NORMAL);
		return false;
	}
	else
	{
		$("#answer-show").val('');
		//$("#answer-show").text('');
	}
}

function cleanUpSpecialChars(str)
{
    str = str.replace(/[èéêë]/g,"e");
    str = str.replace(/[ÀÁÂÃÄÅ]/g,"A");
    str = str.replace(/[àáâãäå]/g,"a");
    str = str.replace(/[ÈÉÊË]/g,"E");

    return str.replace(/[^a-z0-9]/gi,''); // final clean up
}

function checkAnswer(checkOptions)
{
	quiz.setButtonStates(RUNSTATE_CHECKING);
	$("#question-prompt").hide();

	var answerRaw = getAnswer();	
	var answer = cleanUpSpecialChars(answerRaw);
	var attempt = $("#attempt").val();
	var result = '';
	var answerColor = 'black';
		
	if (checkOptions == CHECKANSWER_KNOW)
	{
		answerColor = 'blue';
		result = "The answer is: ";
		quiz.correct[quiz.order[curr]] = true;
		$("#button-next-attempt").focus();
		quiz.showOverrideButton(true, OVERRIDE_WRONG);
		quiz.lastScore = SCORE_CORRECT;
		$("#question-right").show();
		
		right++;		
	}
	else if (checkOptions == CHECKANSWER_DONTKNOW)
	{
		result = "The answer is: ";
		answerColor = 'red';
		$("#button-next-attempt").focus();
		quiz.showOverrideButton(true, OVERRIDE_RIGHT);
		quiz.lastScore = SCORE_WRONG;
		$("#question-wrong").show();
		
		wrong++;
	}
	else
	{
		//
		// typing the answers so check the entry
		//
		if ((answer != null && attempt != null) && answer.toLowerCase() == attempt.toLowerCase())
		{
			result = "Correcto! ";
			answerColor = 'darkBlue';
			quiz.correct[quiz.order[curr]] = true;
			$("#button-next-attempt").focus();
			quiz.showOverrideButton(false, OVERRIDE_WRONG);
			quiz.lastScore = SCORE_WRONG;
			$("#question-right").show();
			right++;		
		}
		else
		{
			result = "WRONG - the answer is: ";
			answerColor = 'red';
			$("#button-next-attempt").focus();
			quiz.showOverrideButton(true, OVERRIDE_RIGHT);
			quiz.lastScore = SCORE_WRONG;
			$("#question-wrong").show();
			wrong++;
		}
	}	
		
	var answerMsg = result + answer;
	if (answer != answerRaw)
		answerMsg += " (" + answerRaw + ")";
		
	//alert(answer);

	if (false)
	{
		$("#answer-show").text(answerMsg);
		$("#answer-show").val(answerMsg);
	}
	else
	{
		$("#answer-show-div").text(answerMsg);	
		$("#answer-show-div").css('color', answerColor);				
	}
	
	updateScore();
}

function updateScore()
{
	$("#statsScore").html("<span class='quizStats'>Correct: " + right + " of " + (right+wrong) + "</span>");
	$("#statsCount").html("<span class='quizStats'>Round " + round + ": " + nbr + "/" + statsMax + "</span>");
	$("#statsDebug").html("<span class='quizStats'>" 
		+ "round=" + round 
		+ ", right=" + right
		+ ", wrong=" + wrong
		+ ", curr=" + curr
		+ ", order=" + quiz.order[curr]
		+ ", nbr=" + nbr 
		+ ", max=" + max
		+ ", statsMax=" + statsMax 
		+ "<br/>"
		+ "order=" + quiz.order.toString()
		+ ", correct=" + toStringBoolArray(quiz.correct)
		+ "<br/>"
		+ "<span style='font-size: 55%; '>"
		+ "q=" + quiz.questions.toString()
		+ "</span>"
		+ "</span>");
}

function override()
{
	quiz.showOverrideButton(false, null);

	var answer = getAnswer();
	var result = "";
	var color = "black";

	if (quiz.lastScore == SCORE_NOTSET)
	{
		// no action
		alert('bad logic: no last score');
	}
	else if (quiz.lastScore == SCORE_WRONG)
	{
		//
		// it was wrong, make it right
		//
		quiz.correct[quiz.order[curr]] = true;
		$("#question-right").show();
		$("#question-wrong").hide();
		$("#question-prompt").hide();
		result = "Correct: ";
		color = "darkBlue";
		right++;
		wrong--;	
	}
	else if (quiz.lastScore == SCORE_CORRECT)
	{
		//
		// it was right, make it wrong
		//
		$("#question-right").hide();
		$("#question-wrong").show();
		$("#question-prompt").hide();
		quiz.correct[quiz.order[curr]] = false;
		result = "Wrong: ";
		color = "red";
		
		right--;	
		wrong++;
	}

	answer = result + answer;
	$("#answer-show").text(answer);
	$("#answer-show").val(answer);
	$("#answer-show").css("color", color);
	$("#answer-show-div").text(answer);
	$("#answer-show-div").val(answer);
	$("#answer-show-div").css("color", color);
	updateScore();
	$("#button-next-attempt").focus();
}
