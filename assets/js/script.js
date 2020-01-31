$(function ($) {
    "use strict";

    let state = 'all';
    
    $('.option').on('click',function(){
        state = $(this).data('state');
        $('.option').removeClass('active');
        $(this).addClass('active');
        $.get($(this).data('href'), function(data) {
          $('#todos').html(data);
        });
      });

    $(document).on({
        mouseenter: function(){
          $(this).find('.delete').removeClass('d-none');
        },
        mouseleave: function(){
          $(this).find('.delete').addClass('d-none');
        }
    }, 'tr.sects');

  $('#todo-form').on('submit',function(e){
    $('#data').prop('readonly',true);
    e.preventDefault();
        $.ajax({
        method:"POST",
        url:$(this).prop('action'),
        data:new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
          $('#cnt').html(data);
          $('.all').click();
          $('#data').prop('readonly',false).val('');
          $('#content,#icn').removeClass('d-none');
        }

        });
  });

  $(document).on('click','.delete',function(){
    var $this = $(this);
    $.get($(this).data('href'), function(data) {
      $this.parent().parent().remove();
      $('#cnt').html(data);
      if(data == 0){
        $('#content,#icn,.ccmplt').addClass('d-none');
        $('#todos').html('');
      }
    });
  });

  $(document).on('click','.txt',function(){
    var $this = $(this).parent();
    $this.addClass('d-none');
    $this.prev().addClass('d-none');
    $this.next().addClass('d-none');
    $this.next().next().removeClass('d-none').find('.edt').prop('required',true).focus();

  });


  $(document).on('mouseleave','.edt',function(){
    var $this = $(this).parent().parent();
    $this.addClass('d-none');
    $(this).val('').prop('required',false);
    $this.prevAll().removeClass('d-none');
    
  });


 $(document).on('submit','.edit-form',function(e){
  var $this = $(this).parent();
  $this.find('.edt').prop('readonly',true)
    e.preventDefault();
        $.ajax({
         method:"POST",
         url:$(this).prop('action'),
         data:new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         success:function(data)
         {
          $this.find('.edt').val('').prop('readonly',false);
          $this.addClass('d-none');
          $this.prev().prev().find('.txt').html(data);
          $this.prevAll().removeClass('d-none');
         }
  
        });
  });

  $(document).on('change','.checkers',function(e){
    if($(this).hasClass('nk')){
      $(this).parent().parent().parent().hide();
    }
    if(this.checked){
      $(this).parent().next().find('.txt').addClass('strikeout');
      $.get($(this).data('check'), function(data) {
        $('#cnt').html(data);
      });
    }else{
      $(this).parent().next().find('.txt').removeClass('strikeout');
      $.get($(this).data('uncheck'), function(data) {
        $('#cnt').html(data);
      });
    }
    if($('.checkers:checked').length > 0){
      $('.ccmplt').removeClass('d-none');
    }else{
      $('.ccmplt').addClass('d-none');
    }
  });
  $('.ccmplt').on('click',function(){
    $(this).addClass('d-none');
    $.get($(this).data('href'), function(data) {
      $('.'+state).click();
      $('#cnt').html(data);
      if(data == 0){
        $('#content,#icn').addClass('d-none');
        $('#todos').html('');
      }
    });
  });



});