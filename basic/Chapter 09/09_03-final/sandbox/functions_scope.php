<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Functions: Scope</title>
	</head>
	<body>
		
		<?php
		
			$bar = "outside";   // global scope
			
			function foo() {
				global $bar;
				if (isset($bar)) {
					echo "foo: " . $bar . "<br />";
				}
				$bar = "inside";  // local scope
			}
		
			echo "1: " . $bar . "<br />";
			foo();
			echo "2: " . $bar . "<br />";

        echo "<hr />";

//
//        function bar() {
//            global $bar;
//            if (isset($bar)) {
//                echo "foo: " . $bar . "<br />";
//            }
//            $bar = "inside1";  // local scope
//        }
//        echo "3: " . $bar . "<br />";
//        bar();
//        echo "4: " . $bar . "<br />";
//
//		?>
		
	</body>
</html>
