<?php

function cypherString($str)
{
    /*
    Data privacy is really important to us. 
	Unfortunately, some bugs can only be reproduced if we have actual production data to validate against. 
	Please write a super secure encryption algorithm changing all these occurences of chars to the cyphered version:
   		A, a -> 4
   		E, e -> 3
   		I, i -> 1
   		O, o -> 0
   		B, b -> 8
   		S, s -> 6
	*/
	$array = [
		'a' => 4,'A' => 4,
		'e' => 3,'E' => 3,
		'i' => 1,'I' => 1,
		'o' => 0,'O' => 0,
		'b' => 8,'B' => 8,
		's' => 6,'S' => 6,
	];

   return strtr($str, $array);
}

echo cypherString('Benjamin').PHP_EOL;
echo cypherString('Javi').PHP_EOL;
echo cypherString('Drinks&Co is a great place to work').PHP_EOL;
echo cypherString('This exercise is a bit quirky!').PHP_EOL;
echo cypherString('AEIOBSzzzzaeiobszzzz!').PHP_EOL;
