$(document).ready(function(){
  localStorage.removeItem('history');

})


$(function() {
  var buttons = $('.btn-group .btn');
  var maxHeight = 0;
  buttons.each(function() {
      if ($(this).height() > maxHeight) {
          maxHeight = $(this).height();
      }
  });
  buttons.height(maxHeight);
  buttons.css('white-space', 'nowrap');
  var fontSize = parseInt(buttons.css('font-size'));
  var maxWidth = $('.btn-group').width() / 3 - 16;
  while (buttons.width() > maxWidth && fontSize > 10) {
      fontSize--;
      buttons.css('font-size', fontSize + 'px');
  }

  $(".cal").on('click',function(){
    let tanka=parseFloat($(this).attr('data-price')) || 0;
    let total=parseFloat($('#calc_area').val().replace(/,/g,"")) || 0;
    let result=tanka+total;
    let name=$(this).val();
    $('#calc_area').val(comma(result));

    let history=JSON.parse(localStorage.getItem('history')) || [];
    history.push({
      name:name,
      price:tanka
    });
    localStorage.setItem('history',JSON.stringify(history));

    //var item = $('<li>').text(name + ' ' + tanka + '円');
    var item='<li style="border-bottom:1px solid;"><a href="#" style="margin-right:5px;">削除</a>'+ name + ' <span class="history_tanka">' + tanka + '</span>円';
    var historyList = $('#history-list');
    historyList.append(item);
/*
  history = JSON.parse(localStorage.getItem('history')) || [];

  // 履歴を表示する要素を取得
  var $historyList = $('#history-list');
  
  // 履歴を表示
  history.forEach(function(item) {
    var $item = $('<li>').text(item.name + ' ' + item.price + '円');
    $historyList.append($item);
  });
  */
  });

  $(".arrow").on('click',function(){
    $("#history-list").fadeToggle();
  })

  $("#history-list").on('click','li a',function(){
    let tanka=parseFloat($(this).next('span').text().replace(/,/g,"")) || 0;
    let total=parseFloat($('#calc_area').val().replace(/,/g,"")) || 0;
    let result=total-tanka;
    $("#calc_area").val(comma(result));
    $(this).parent().remove();
  });

  $("#history-list").on('swipeleft','li',function(){
    console.log('swipe');

    $(this).remove();
  })




});



function comma(num){
  var str = num.toString().split('.');
  if (str[0].length >= 4) {
      str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
  }
  if (str[1] && str[1].length >= 4) {
      str[1] = str[1].replace(/(\d{3})/g, '$1 ');
  }
  return str.join('.');
}