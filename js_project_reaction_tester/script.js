			// change figures properties
			// some of those functions could be just variables
			
			function getRandomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++) {
					color += letters[Math.floor(Math.random() * 16)];
					if (color == "#FFFFFF") {
						color = "#F1F1F1";
					}
				}
				return color;
				}
				
			function changeColor() {
				document.getElementById("figures").style.backgroundColor = getRandomColor();
			}
				
			function getRandomSize() {
				var size = "";
				size = Math.floor((Math.random() * 200)+100)+"px";
				return size;
			}
			
			function changeSize() {
				size = getRandomSize();
				document.getElementById("figures").style.height = size;
				document.getElementById("figures").style.width = size;
			}
			
			function getSquareOrCircle() {
				var shape = "";
				var indicator = Math.random();
				if (indicator < 0.5) {
					shape = "0%";
				} else {
					shape = "50%";
				}
				return shape;
			}
			
			function changeShape() {
				document.getElementById("figures").style.borderRadius = getSquareOrCircle();
			}
			
			function getRandomPosition() {
				var position = Math.floor(Math.random() * 600) + "px";
				return position;
			}
			
			function changePosition() {
				document.getElementById("figures").style.top = getRandomPosition();
				document.getElementById("figures").style.left = getRandomPosition();
			}
			
			
			//hide figure
			
			function hideFigure() {
				document.getElementById("figures").style.display = "none";
			}
			
			
			// show figure with changed properties and return a time stamp
			
			function showFigure() {
				document.getElementById("figures").style.display = "block";
				changeColor();
				changeSize();
				changeShape();
				changePosition();
				figureTime = (new Date());
				
			}
			
			// delay showing figure with changed properties
			
			function delayFigure() {
				setTimeout(showFigure, Math.random() * 2000);
				
			}
			
			
			// after user clicks hide figure, show changed figure
			// measure time it takes for the user to click on it and display the result

			var figureTime = new Date();
			
			document.getElementById("figures").onclick = function() {
				var clickTime = (new Date());
				hideFigure();
				var result = ((clickTime - figureTime) / 1000) + "s";
				document.getElementById("time").innerHTML = result;
				delayFigure();
			}
			