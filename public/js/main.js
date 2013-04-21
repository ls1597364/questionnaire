// The root URL for the RESTful services
var rootURL = "http://localhost/new1/question";

var currentQuestion;

// Retrieve question list when application starts 
$('#Next').click(function() {
	findAll();
	return false;
});

// Nothing to delete in initial application state
$('#btnDelete').hide();

// Register listeners
$('#btnSearch').click(function() {
	search($('#searchKey').val());
	return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function(e){
	if(e.which == 13) {
		search($('#searchKey').val());
		e.preventDefault();
		return false;
    }
});

$('#btnAdd').click(function() {
	newquestion();
	return false;
});

$('#btnSave').click(function() {
	if ($('#questionId').val() == '')
		addquestion();
	else
		updatequestion();
	return false;
});

$('#btnDelete').click(function() {
	deletequestion();
	return false;
});

$('#questionList a').live('click', function() {
	findById($(this).data('identity'));
});

// Replace broken images with generic question bottle
$("img").error(function(){
  $(this).attr("src", "pics/generic.jpg");

});

function search(searchKey) {
	if (searchKey == '') 
		findAll();
	else
		findByName(searchKey);
}

function newquestion() {
	$('#btnDelete').hide();
	question = {};
	renderDetails(question); // Display empty form
}

function findAll() {
	console.log('findAll');
	$.ajax({
		type: 'GET',
		url: rootURL,
		dataType: "json", // data type of response
		success: renderList
	});
}

function findByName(searchKey) {
	console.log('findByName: ' + searchKey);
	$.ajax({
		type: 'GET',
		url: rootURL + '/search/' + searchKey,
		dataType: "json",
		success: renderList 
	});
}

function findById(id) {
	console.log('findById: ' + id);
	$.ajax({
		type: 'GET',
		url: rootURL + '/' + id,
		dataType: "json",
		success: function(data){
			$('#btnDelete').show();
			console.log('findById success: ' + data.name);
			question = data;
			renderDetails(question);
		}
	});
}

function addquestion() {
	console.log('addquestion');
	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('question created successfully');
			$('#btnDelete').show();
			$('#questionId').val(data.id);
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('addquestion error: ' + textStatus);
		}
	});
}

function updatequestion() {
	console.log('updatequestion');
	$.ajax({
		type: 'PUT',
		contentType: 'application/json',
		url: rootURL + '/' + $('#questionId').val(),
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('question updated successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('updatequestion error: ' + textStatus);
		}
	});
}

function deletequestion() {
	console.log('deletequestion');
	$.ajax({
		type: 'DELETE',
		url: rootURL + '/' + $('#questionId').val(),
		success: function(data, textStatus, jqXHR){
			alert('question deleted successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('deletequestion error');
		}
	});
}

function renderList(data) {
	// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
	var list = data == null ? [] : (data.question instanceof Array ? data.question : [data.question]);

	$('#questionList li').remove();
	$.each(list, function(index, question) {
		$('#questionList').append('<li><a href="#" data-identity="' + question.id + '">'+question.question+'</a></li>');
	});
}

function renderDetails(question) {
	$('#questionId').val(question.id);
	$('#name').val(question.name);
	$('#grapes').val(question.grapes);
	$('#country').val(question.country);
	$('#region').val(question.region);
	$('#year').val(question.year);
	$('#pic').attr('src', 'pics/' + question.picture);
	$('#description').val(question.description);
}

// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
	return JSON.stringify({
		"id": $('#questionId').val(), 
		"name": $('#name').val(), 
		"grapes": $('#grapes').val(),
		"country": $('#country').val(),
		"region": $('#region').val(),
		"year": $('#year').val(),
		"picture": question.picture,
		"description": $('#description').val()
		});
}
