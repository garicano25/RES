<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    /*
Source - https://stackoverflow.com/a
Posted by Flame, modified by community. See post 'Timeline' for change history
Retrieved 2025-11-14, License - CC BY-SA 4.0
*/

canvas#signature {
  border: 2px solid black;
}

form>* {
  margin: 10px;
}

</style>
<body>
    


    <!--
    Source - https://stackoverflow.com/a
    Posted by Flame, modified by community. See post 'Timeline' for change history
    Retrieved 2025-11-14, License - CC BY-SA 4.0
    -->
    
        <div>
            <input name="name" placeholder="Your name" required />
        </div>
        <div>
            <canvas id="signature" width="300" height="100"></canvas>
        </div>
        <div>
            <input type="hidden" name="signature" />
        </div>


</body>


<script>


    // Source - https://stackoverflow.com/a
        // Posted by Flame, modified by community. See post 'Timeline' for change history
        // Retrieved 2025-11-14, License - CC BY-SA 4.0

        var canvas = document.getElementById('signature');
        var ctx = canvas.getContext("2d");
        var drawing = false;
        var prevX, prevY;
        var currX, currY;
        var signature = document.getElementsByName('signature')[0];

        canvas.addEventListener("mousemove", draw);
        canvas.addEventListener("mouseup", stop);
        canvas.addEventListener("mousedown", start);

        function start(e) {
            drawing = true;
        }

        function stop() {
            drawing = false;
            prevX = prevY = null;
            signature.value = canvas.toDataURL();
        }

        function draw(e) {
            if (!drawing) {
                return;
            }
            // Test for touchmove event, this requires another property.
            var clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
            var clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
            currX = clientX - canvas.offsetLeft;
            currY = clientY - canvas.offsetTop;
            if (!prevX && !prevY) {
                prevX = currX;
                prevY = currY;
            }

            ctx.beginPath();
            ctx.moveTo(prevX, prevY);
            ctx.lineTo(currX, currY);
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.closePath();

            prevX = currX;
            prevY = currY;
        }

        function onSubmit(e) {
            console.log({
                'name': document.getElementsByName('name')[0].value,
                'signature': signature.value,
            });
            return false;
        }
</script>
</html>