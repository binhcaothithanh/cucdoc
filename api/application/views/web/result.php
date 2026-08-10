<View class="ResultZone">
  <br/>
  <View class="w-100">
    <span class="text-center" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); font-size: 25px">Your question:</span>
  </View>
  <View class="w-100">
    <p class="text-center" style="max-width: 220px">
      <span>"</span>
    <?php
      echo($question);
     ?>
     <span>"</span>
    </p>
  </View>
  <Br />
  <View class="w-100">
    <span class="text-center" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); font-size: 25px">
      God's answer:
    </span>
  </View>
  <View class="w-100">
    <p class="text-center" style="max-width: 220px">"
    <?php
      echo($answer);
     ?>"
    </p>
    <form id="myForm" name="myForm" action="/pray" method="post" style="display: flex; flex-direction: column; align-items: center">
      <button type="submit" class="btn" style="background-color: #f4b956">Back</button>
      <Br />
    </form>
  </View>
</View>
<div style="clear: both;"></div>


<script>
  $('#myForm').on('submit', function (e) {
    e.preventDefault(); // prevent default form post

    $.ajax({
      type: 'POST',
      url: '/index/backHome',
      data: $(this).serialize(),
      success: function (response) {
        // alert(response);
        $('#contentDisplay').html(response); // or show a success message

      }
    });
  });
</script>
