<View id="contentHome" name="contentHome" style="border: solid 1px black; display: flex; flex-direction: column;
 align-items: center;justify-content: center; padding-top: 10px; background: white">
  <span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); font-size: 25px">
    THIS IS GOD OF DECISION
  </span>
  <form id="myForm" name="myForm" action="/pray" method="post" style="display: flex; flex-direction: column; align-items: center">
    <textarea id="question" name="question" required class="textQuestion" rows="3" cols="50" placeholder="input your question here (Remember just ask a question for answer about yes or no). Ex: Should I give up with her?" ></textarea>
    <button type="submit" class="buttonPray"></button>
</form>
  <br />
  <span style="font-size:9px">Touch the hand to start praying</span> <br />
</View>
<script>
  $('#myForm').on('submit', function (e) {
    e.preventDefault(); // prevent default form post
    $('#contentHome').html('<Div style="width: 100%; display: flex; flex-direction: column; align-items: center;justify-content: center;"><span style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); font-size: 25px">Praying...</span><div class="Listofgod"> </div></Div>'); // show loading text or spinner

    $.ajax({
      type: 'POST',
      url: '/pray',
      data: $(this).serialize(),
      success: function (response) {
        // alert(response);

        setTimeout(function () {

        $('#contentDisplay').html(response); // or show a success message
        $('#myForm')[0].reset(); // optional: reset form
      }, 2000); // 2000 ms = 2 seconds
      }
    });
  });
</script>
