$(function () {
	$('.event-list').slimscroll({
            height: '305px',
            wheelStep: 20
        });

    var counter = 0;

    $( ".todo-list, .doing-list, .done-list" ).sortable({
    connectWith: ".event-list",
    appendTo: "body",
    placeholder: "listitem",
    helper: "clone",
    cursor: "move",
    receive: function( event, ui ) {
        var status = $(this).attr("class");
        status = status.substring(0,status.indexOf('-'));
        var id = ui.item.attr("id");
        $.ajax({
            url: 'functions.php?method=updatenotes&status=' +status+ '&id=' +id,
            type: 'GET',
            dataType: 'json',
            error: function(e)
            {
                console.log('error');
            }
        });
    }
    });

     $(document.body).on('click', "a[id*='project-']" ,function (e) {
        var name = $(this).attr("name");
        $('.event-list').fadeOut(250, function() {
            var container = $(this).attr("name");
            $(this).empty();
            counter++;
            if (counter< 2)
            {
                $('#displayed-project-name').fadeOut(250, function() {
                    $(this.empty);
                    $(this).html(name);
                });
                $('#displayed-project-name').fadeIn();
                $('#project-name').val(name);
            }
            $.ajax({
                url: 'functions.php?method=ajaxloadnotes&name=' +name+ '&status=' +container.substring(0,container.indexOf('-')),
                type: 'GET',
                dataType: 'json',
                success: function(s){
                    if(s.status == 'success')
                    {
                        $.each(s.results, function(key, value){
                            $('<li class="listitem" id="'+value.id+'">' + value.description + '<a href="#"" class="event-close"> &#10005; </a> </li>').appendTo('.' + container);
                        });
                    }
                },
                error: function(e)
                {
                    console.log('error! type: ' + e.type);
                }
            });
        });
        $('.event-list').fadeIn(250);
        counter = 0;
        return false;
        e.epreventDefault();
        e.stopPropagation();
    });

     $('#create-project-button').click(function (e) {
        var inText = $('#create-project-input').val();
        if (inText == "") {
            alert('Projects must have a name');
        } else {
            $.ajax({
                url: 'functions.php?method=newproject&name=' +inText,
                type: 'GET',
                dataType: 'json',
                success: function(s){
                    if(s.status == 'success')
                    {
                        $('#projects-dropdown').empty();
                        $.ajax({
                            url: 'functions.php?method=ajaxgetprojects',
                            type: 'GET',
                            dataType: 'json',
                            success: function(s){
                                if(s.status == 'success')
                                {
                                    $.each(s.results, function(key, value){
                                        $('<li><a id="project-' + value.id + '" name="'+ value.name + '">' + value.name + '</a></li>').appendTo('#projects-dropdown');
                                    });
                                }
                                $('#new-project').modal('hide')
                                $('#create-project-input').val('');
                                $('a[name="'+ inText +'"]').trigger( "click" );
                            },
                            error: function(e)
                            {
                                console.log('error! type: ' + e.type);
                            }
                        });
                    }
                },
                error: function(e)
                {
                    console.log('error! type: ' + e.type);
                }
            });
        }
        return false;
        e.epreventDefault();
        e.stopPropagation();

    });

     $('#delete-project-button').click(function (e) {
        $.ajax({
            url: 'functions.php?method=deleteproject&name=' + $('#project-name').val(),
            type: 'GET',
            dataType: 'json',
            success: function(s){
                if(s.status == 'success')
                {
                    $('#projects-dropdown').empty();
                    $.ajax({
                        url: 'functions.php?method=ajaxgetprojects',
                        type: 'GET',
                        dataType: 'json',
                        success: function(s){
                            if(s.status == 'success')
                            {
                                $.each(s.results, function(key, value){
                                    $('<li><a id="project-' + value.id + '" name="'+ value.name + '">' + value.name + '</a></li>').appendTo('#projects-dropdown');
                                });
                            }
                            $('#delete-project').modal('hide')
                            $('#create-project-input').val('');
                            $('a[name="default"]').trigger( "click" );
                        },
                        error: function(e)
                        {
                            console.log('error! type: ' + e.type);
                        }
                    });
                }
            },
            error: function(e)
            {
                console.log('error! type: ' + e.type);
            }
        });
        return false;
        e.epreventDefault();
        e.stopPropagation();
    });

    $('#create-project-input').keypress(function (e) {
        var p = e.which;
        if (p == 13) {
            $('#create-project-button').trigger( "click" );
        }
    });

    $('.todo-input').keypress(function (e) {
        var p = e.which;
        if (p == 13) {
            var inText = $('.todo-input').val();
            if (inText == "") {
                alert('Empty Field');
            } else {
				$.ajax({
					url: 'functions.php?method=addnotes&status=todo&data='+inText+ '&project=' + $('#project-name').val(),
					type: 'GET',
					dataType: 'json',
					success: function(s){
						if(s.status == 'success')
                         $('<li class="listitem" id="'+s.id+'">' + inText + '<a href="#"" class="event-close"> &#10005; </a> </li>').appendTo('.todo-list');
					},
					error: function(e)
					{
                        console.log('error');
					}
				});
            }
            $(this).val('');
            $('.todo-list').scrollTop('100%', '100%', {
                easing: 'swing'
            });
            return false;
            e.epreventDefault();
            e.stopPropagation();
        }
    });

    $('.doing-input').keypress(function (e) {
        var p = e.which;
        if (p == 13) {
            var inText = $('.doing-input').val();
            if (inText == "") {
                alert('Empty Field');
            } else {
				$.ajax({
					url: 'functions.php?method=addnotes&status=doing&data='+inText+ '&project=' + $('#project-name').val(),
					type: 'GET',
					dataType: 'json',
					success: function(s){
						if(s.status == 'success')
                         $('<li class="listitem" id="'+s.id+'">' + inText + '<a href="#"" class="event-close"> &#10005; </a> </li>').appendTo('.doing-list');
					},
					error: function(e)
					{
						console.log('error');
					}
				});
            }
            $(this).val('');
            $('.doing-list').scrollTop('100%', '100%', {
                easing: 'swing'
            });
            return false;
            e.epreventDefault();
            e.stopPropagation();
        }
    });

    $('.done-input').keypress(function (e) {
        var p = e.which;
        if (p == 13) {
            var inText = $('.done-input').val();
            if (inText == "") {
                alert('Empty Field');
            } else {
				$.ajax({
					url: 'functions.php?method=addnotes&status=done&data='+inText+ '&project=' + $('#project-name').val(),
					type: 'GET',
					dataType: 'json',
					success: function(s){
						if(s.status == 'success')
                         $('<li class="listitem" id="'+ s.id +'">' + inText + '<a href="#"" class="event-close"> &#10005; </a> </li>').appendTo('.done-list');
					},
					error: function(e)
					{
						console.log('error');
					}
				});
            }
            $(this).val('');
            $('.done-list').scrollTop('100%', '100%', {
                easing: 'swing'
            });
            return false;
            e.epreventDefault();
            e.stopPropagation();
        }
    });
	
	 $(document).on('click', '.event-close', function () {
		var id = $(this).closest("li").attr('id');
				$.ajax({
					url: 'functions.php?method=delnotes&id='+id,
					type: 'GET',
					dataType: 'json',
					success: function(s){
						if(s.status == 'success')
                        {
                            $('#'+id).fadeOut(250, function() {
                                (this).remove();
                            });
                        }
					},
					error: function(e)
					{
						console.log('error');
					}
				});
        return false;
    });

    $('#search').keypress(function (e) {
        var p = e.which;
        if (p == 13) {
            e.preventDefault();
            return false;
        }
    });

});
