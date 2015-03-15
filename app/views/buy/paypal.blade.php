

@if (isset($url))
<script type="text/javascript">

  window.location.replace('http://littlehelper.chainsaw:8000/ourStory');

  var new_tab = window.open('<?php echo $url; ?>', '_blank');
  new_tab.focus();
</script>
@endif