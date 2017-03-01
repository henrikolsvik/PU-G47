 <script>
    function changeColor(){
        color="green";
        document.body.style.background = color;
        setTimeout(function(){ 
            color = "white";
            document.body.style.background = color; 
            }, 500);
        return true;
    }
    function textEffect(){
        document.getElementById('statusSend').innerHTML = 'Feedback Sent!';
        document.getElementById('statusSend').style.color = 'black';
        setTimeout(function(){ 
            document.getElementById('statusSend').innerHTML = 'Please submit your feedback for lecture: <?php echo($lectureName) ?>';
            document.getElementById('statusSend').style.color = 'black';
            }, 500);
        changeColor();
        return true; 
    }
</script>