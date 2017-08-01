<?php
	function gradeQuestion($param1,$param2,$param3,$points,$type){
		if($type==="Function"){
			$testCases=explode(" ",$param1);
			$keywords=explode(" ",$param2);
			$answer=$param3;		
			$lines=explode("\r\n",$answer);
			$params=array();
			$returned=substr($answer,strlen($answer)-1,1);//returned variable
			$letters="/[a-zA-Z]/";
			$score=$points;
			$deduct=$points/10;
			$comment=null;
			if(empty($answer)){
				$score=0;//if no answer given
				$comment="No answer given. No credit given.";
			}
			if($score>0){
				if(substr($lines[0],0,3)!==$keywords[0]){
					$score-=$deduct;//if def is not the first 3 characters
					$comment=$comment."-".$deduct.": Function does not start with \"def\".\n";
				}
				if(!strpos($lines[0],$keywords[1])){
					$score-=$deduct;//if the name of the function is not in the first line
					$comment=$comment."-".$deduct.": Function does not have the name in the first line.\n";
				}
				for($i=0; $i<strlen($lines[0]); $i++){
					$ch=substr($lines[0],$i,1);
					if($ch==="," && preg_match($letters,substr($lines[0],$i-1,1)) && preg_match($letters,substr($lines[0],$i+1,1))){
						array_push($params,substr($lines[0],$i-1,1));
						array_push($params,substr($lines[0],$i+1,1));
						break;//gets the parameter variables
					}
				}
				$emptyParams=false;
				if(empty($params)){//if the parameter variables
					$params[0]="a";//are left out of the first line of code
					$params[1]="b";//this gives them values for later
					$score-=$deduct;
					$emptyParams=true;
					$comment=$comment."-".$deduct.": No parameters entered.\n";
				}
				$sameParams=false;
				if($params[0]===$params[1]){
					if($params[1]!=="b"){//if they are the same, this fixes it
						$params[1]="b";
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Parameters are the same.\n";
					}
					else{
						$params[1]="a";
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Parameters are the same.\n";
					}
					$sameParams=true;
				}
				$equationPattern="/ +".$returned."=".$params[0]."[\+\-\*\/]".$params[1]."/";
				$equationPattern2="/ +".$returned."=int".$params[1]."[\+\-\*]".$params[0]."/";
				$returnPattern="/ +return ".$returned."/";
				if(!preg_match($equationPattern,$lines[sizeof($lines)-2]) && !preg_match($equationPattern2,$lines[sizeof($lines)-2])){
					$score-=$deduct;
					$comment=$comment."-".$deduct.": Arithmetic statement is not formatted properly.\n";
				}
				if(!preg_match($returnPattern,$lines[sizeof($lines)-1])){
					$score-=$deduct;//checks if the return line is present and properly formatted
					$comment=$comment."-".$deduct.": Return statement is not formatted properly.\n";
				}
				if($emptyParams || $sameParams){
					$string="def ".$keywords[1]."(,):";
					$comma=strpos($string,",");
					$string=substr_replace($string,"b",$comma+1, 0);
					$string=substr_replace($string,"a",$comma, 0);
					$lines[0]=$string;//adds parameters to original string if none given
				}//also does this if the parameters are the same
				$string=null;
				for($i=0; $i<sizeof($lines); $i++){
					$string=$string.$lines[$i]."\n";
				}//changes the answer to a format that can be compiled
				$shebang="#!/usr/bin/env python\n";//creates the other lines of the code
				$sys="import sys\n";
				$fname="pyfile.py";
				$pyfile=fopen($fname,"w+") or die("didn't work");
				chmod($fname, 0744);
				$line5="a=sys.argv[1]\n";
				$line6="b=sys.argv[2]\n";
				$line7="c=".$keywords[1]."(int(a),int(b))\n";
				$line8="print c";//produces output
				fwrite($pyfile,$shebang);
				fwrite($pyfile,$sys);
				fwrite($pyfile,$string);
				fwrite($pyfile,$line5);
				fwrite($pyfile,$line6);
				fwrite($pyfile,$line7);
				fwrite($pyfile,$line8);
				fclose($pyfile);//for writing each line to the file then closing it
				$command=escapeshellcmd('./'.$fname.' '.$testCases[0].' '.$testCases[1]);//executing the file with test cases
				$output=shell_exec($command);//gets output
				$output=trim($output);
				if(is_null($output)){
					$score-=$deduct*5;//deducts half credit if it doesn't compile
					$comment=$comment."-".($deduct*5).": Your written code does not compile.\n\n";
				}
				else{
					if($output!==$testCases[2]){
						$score-=$deduct*3;//deducts 2 if it compiles but wrong answer
						$comment=$comment."-".($deduct*3).": Your output is not valid based on the problem requirements.\n\n";
					}
				}
			}
			if($score<1){
				$score=0;
			}
			$comment=$comment."Score for this problem: ".$score."/".$points;
			$final=array($score,$comment);
		}
		else if($type==="Exponent"){
			$testCases=explode(" ",$param1);
			$keywords=explode(" ",$param2);
			$answer=$param3;		
			$lines=explode("\r\n",$answer);
			$params=array();
			$returned=substr($answer,strlen($answer)-1,1);//returned variable
			$letters="/[a-zA-Z]/";
			$score=$points;
			$deduct=$points/10;
			$comment=null;
			if(empty($answer)){
				$score=0;//if no answer given
				$comment="No answer given. No credit given.";
			}
			if($score>0){
				if(substr($lines[0],0,3)!==$keywords[0]){
					$score-=$deduct;//if def is not the first 3 characters
					$comment=$comment."-".$deduct.": Function does not start with \"def\".\n";
				}
				if(!strpos($lines[0],$keywords[1])){
					$score-=$deduct;//if the name of the function is not in the first line
					$comment=$comment."-".$deduct.": The first line does not contain the function name.\n";
				}
				for($i=0; $i<strlen($lines[0]); $i++){
					$ch=substr($lines[0],$i,1);
					if($ch==="," && preg_match($letters,substr($lines[0],$i-1,1)) && preg_match($letters,substr($lines[0],$i+1,1))){
						array_push($params,substr($lines[0],$i-1,1));
						array_push($params,substr($lines[0],$i+1,1));
						break;//gets the parameter variables
					}
				}
				if(empty($params)){
					array_push($params,"a");
				}
				$emptyParams=false;
				if(empty($params)){//if the parameter variables
					$params[0]="a";//are left out of the first line of code
					$params[1]="b";//this gives them values for later
					$score-=$deduct;
					$emptyParams=true;
					$comment=$comment."-".$deduct.": No parameters entered.\n";
				}
				$sameParams=false;
				if($params[0]===$params[1]){
					if($params[1]!=="b"){//if they are the same, this fixes it
						$params[1]="b";
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Parameters are the same.\n";
					}
					else{
						$params[1]="a";
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Parameters are the same.\n";
					}
					$sameParams=true;
				}
				if(sizeof($params)===2){
					$equationPattern="/ +".$returned."=".$params[0]."\*\*".$params[1]."/";
					$equationPattern2="/ +".$returned."=".$params[1]."\*\*".$params[0]."/";
					if(!preg_match($equationPattern,$lines[sizeof($lines)-2]) && !preg_match($equationPattern2,$lines[sizeof($lines)-2])){
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Arithmetic statement is not formatted properly.\n";
					}
				}
				else if(sizeof($params)===1){
					$equationPattern="/ +".$returned."=".$params[0]."\*\*".$params[0]."/";
					if(!preg_match($equationPattern,$lines[sizeof($lines)-2])){
						$score-=$deduct;
						$comment=$comment."-".$deduct.": Arithmetic statement is not formatted properly.\n";
					}
				}
				$returnPattern="/ +return ".$returned."/";
				if(!preg_match($returnPattern,$lines[sizeof($lines)-1])){
					$score-=$deduct;//checks if the return line is present and properly formatted
					$comment=$comment."-".$deduct.": Return statement is not formatted properly.\n";
				}
				if($emptyParams || $sameParams){
					$string="def ".$keywords[1]."(,):";
					$comma=strpos($string,",");
					$string=substr_replace($string,"b",$comma+1, 0);
					$string=substr_replace($string,"a",$comma, 0);
					$lines[0]=$string;//adds parameters to original string if none given
				}//also does this if the parameters are the same
				$string=null;
				for($i=0; $i<sizeof($lines); $i++){
					$string=$string.$lines[$i]."\n";
				}//changes the answer to a format that can be compiled
				$shebang="#!/usr/bin/env python\n";//creates the other lines of the code
				$sys="import sys\n";
				$fname="pyfile.py";
				$pyfile=fopen($fname,"w+") or die("didn't work");
				chmod($fname, 0744);
				$line5="a=sys.argv[1]\n";
				$line6="b=sys.argv[2]\n";
				if(sizeof($params)>1){
					$line7="c=".$keywords[1]."(int(a),int(b))\n";
				}
				else{
					$line7="c=".$keywords[1]."(int(a))\n";
				}
				$line8="print c";//produces output
				fwrite($pyfile,$shebang);
				fwrite($pyfile,$sys);
				fwrite($pyfile,$string);
				fwrite($pyfile,$line5);
				fwrite($pyfile,$line6);
				fwrite($pyfile,$line7);
				fwrite($pyfile,$line8);
				fclose($pyfile);//for writing each line to the file then closing it
				$command=escapeshellcmd('./'.$fname.' '.$testCases[0].' '.$testCases[1]);//executing the file with test cases
				$output=shell_exec($command);//gets output
				$output=trim($output);
				if(is_null($output)){
					$score-=$deduct*5;//deducts half credit if it doesn't compile
					$comment=$comment."-".($deduct*5).": Your written code does not compile.\n\n";
				}
				else{
					if($output!==$testCases[2]){
						$score-=$deduct*3;//deducts 2 if it compiles but wrong answer
						$comment=$comment."-".($deduct*3).": Your output is not valid based on the problem requirements.\n\n";
					}
				}
			}
				$comment=$comment."Score for this problem: ".$score."/".$points;
				$final=array($score,$comment);
		}
		else if($type==="Loop"){
			$testCases=explode(" ",$param1);
			$keywords=explode(" ",$param2);
			$answer=$param3;		
			$lines=explode("\r\n",$answer);
			$param=null;
			$returned=substr($answer,strlen($answer)-1,1);//returned variable
			$letters="/[a-zA-Z]/";
			$score=$points;
			$deduct=$points/8;
			$comment=null;
			for($i=0; $i<strlen($lines[0]); $i++){
				$ch=substr($lines[0],$i,1);
					if($ch===")" && preg_match($letters,substr($lines[0],$i-1,1))){
						$param=substr($lines[0],$i-1,1);
						break;//gets the parameter variables
					}
			}
			if(empty($param)){
				$score-=$deduct;
				$comment=$comment."-".($deduct*3).": No parameter given.\n";
				$param="A";
			}
			$forLoop=false;
			$whileLoop=false;
			if(empty($answer)){
				$score=0;//if no answer given
				$comment="No answer given. No credit given.\n";
			}
			if(strpos($answer,"for")){
				$forLoop=true;
			}
			if(strpos($answer,"while")){
				$whileLoop=true;
			}
			if($forLoop && $whileLoop){
				$score=0;
				$comment=$comment."You are only supposed to use one loop. No credit given.\n";
			}
			else if(!$forLoop && !whileLoop){
				$score=0;//if no answer given
				$comment="No answer given. No credit given.\n";
			}
			if($score>0){
				if(substr($lines[0],0,3)!==$keywords[0]){
					$score-=$deduct;//if def is not the first 3 characters
					$comment=$comment."-".$deduct.": Function does not start with \"def\".\n";
				}
				if(!strpos($lines[0],$keywords[1])){
					$score-=$deduct;//if the name of the function is not in the first line
					$comment=$comment."-".$deduct.": The function name is not in the first line.\n";
				}
				if(!strpos($answer,"return")){
					$score-=$deduct;
					$comment=$comment."-".$deduct.": There is no return statement, or it is not written correctly.\n";
				}
				$string=null;
				for($i=0; $i<sizeof($lines); $i++){
					$string=$string.$lines[$i]."\n";
				}
				$shebang="#!/usr/bin/env python\n";//creates the other lines of the code
				$sys="import sys\n";
				$fname="pyfile.py";
				$pyfile=fopen($fname,"w+") or die("didn't work");
				chmod($fname, 0744);
				$A="[";
				for($i=0; $i<sizeof($testCases)-1; $i++){
					if($i<sizeof($testCases)-2){
						$A=$A.$testCases[$i].",";
					}
					else{
						$A=$A.$testCases[$i]."]";
					}
				}
				$line5=$param."=".$A."\n";
				$line7="c=".$keywords[1]."(".$param.")\n";
				$line8="print c";//produces output
				fwrite($pyfile,$shebang);
				fwrite($pyfile,$sys);
				fwrite($pyfile,$string);
				fwrite($pyfile,$line5);
				fwrite($pyfile,$line7);
				fwrite($pyfile,$line8);
				fclose($pyfile);//for writing each line to the file then closing it
				$command=escapeshellcmd('./'.$fname);//executing the file with test cases
				$output=shell_exec($command);//gets output
				$output=trim($output);
				if(is_null($output)){
					$score-=$points/2;//deducts half credit if it doesn't compile
					$comment=$comment."-".($points/2).": Your written code does not compile.\n\n";
				}
				else{
					if($output!==$testCases[sizeof($testCases)-1]){
						$score-=$points/4;//deducts 2 if it compiles but wrong answer
						$comment=$comment."-".($points/4).": Your output is not valid based on the problem requirements.\n\n";
					}
				}				
			}
			if($score<1){
				$score=0;
			}
			else{
				if($score%1!==0){
					$score=number_format((float)$foo, 2, '.', '');
				}
			}
			$comment=$comment."Score for this problem: ".$score."/".$points;
			$final=array($score,$comment);
		}
		else if($type==="Recursion"){
			$testCases=explode(" ",$param1);
			$keywords=explode(" ",$param2);
			$answer=$param3;		
			$lines=explode("\r\n",$answer);
			$params=array();
			$returned=substr($answer,strlen($answer)-1,1);//returned variable
			$letters="/[a-zA-Z]/";
			$score=$points;
			$deduct=$points/10;
			$comment=null;
			if(empty($answer)){
				$score=0;//if no answer given
				$comment="No answer given. No credit given.\n\n";
			}
			if(substr_count($answer,$keywords[2])<2){
				$score=0;
				$comment="Function does not make any recursive calls. No credit given.\n\n";
			}
			if(substr_count($answer,$keywords[1])<2){
				$score=0;
				$comment="Function does not make any recursive calls. No credit given.\n\n";
			}
			if($score>0){
				if(substr($lines[0],0,3)!==$keywords[0]){
					$score-=$deduct;//if def is not the first 3 characters
					$comment=$comment."-".$deduct.": Function does not start with \"def\".\n";
				}
				if(!strpos($lines[0],$keywords[1])){
					$score-=$deduct*2;//if the name of the function is not in the first line
					$comment=$comment."-".$deduct.": Function does not have name in first line.\n";
				}
				if(sizeof($testCases)>2){
					for($i=0; $i<strlen($lines[0]); $i++){
						$ch=substr($lines[0],$i,1);
						if($ch==="," && preg_match($letters,substr($lines[0],$i-1,1)) && preg_match($letters,substr($lines[0],$i+1,1))){
							array_push($params,substr($lines[0],$i-1,1));
							array_push($params,substr($lines[0],$i+1,1));
							break;//gets the parameter variables
						}
					}
					$emptyParams=false;
					if(empty($params)){//if the parameter variables
						$params[0]="x";//are left out of the first line of code
						$params[1]="p";//this gives them values for later
						$score-=$deduct;
						$emptyParams=true;
						$comment=$comment."-".$deduct.": No parameters entered.\n";
					}
					$sameParams=false;
					if($params[0]===$params[1]){
						if($params[1]!=="p"){//if they are the same, this fixes it
							$params[1]="p";
							$score-=$deduct;
							$comment=$comment."-".$deduct.": Parameters are the same.\n";
						}
						else{
							$params[1]="x";
							$score-=$deduct;
							$comment=$comment."-".$deduct.": Parameters are the same.\n";
						}
						$sameParams=true;
					}
					if($emptyParams || $sameParams){
						$string="def ".$keywords[1]."(,):";
						$comma=strpos($string,",");
						$string=substr_replace($string,"b",$comma+1, 0);
						$string=substr_replace($string,"a",$comma, 0);
						$lines[0]=$string;//adds parameters to original string if none given
					}//also does this if the parameters are the same
					$string=null;
					for($i=0; $i<sizeof($lines); $i++){
						$string=$string.$lines[$i]."\n";
					}//changes the answer to a format that can be compiled
					$shebang="#!/usr/bin/env python\n";//creates the other lines of the code
					$sys="import sys\n";
					$fname="pyfile.py";
					$pyfile=fopen($fname,"w+") or die("didn't work");
					chmod($fname, 0744);
					$line5="a=sys.argv[1]\n";
					$line6="b=sys.argv[2]\n";
					$line7="c=".$keywords[1]."(int(a),int(b))\n";
					$line8="print c";//produces output
					fwrite($pyfile,$shebang);
					fwrite($pyfile,$sys);
					fwrite($pyfile,$string);
					fwrite($pyfile,$line5);
					fwrite($pyfile,$line6);
					fwrite($pyfile,$line7);
					fwrite($pyfile,$line8);
					fclose($pyfile);//for writing each line to the file then closing it
					$command=escapeshellcmd('./'.$fname.' '.$testCases[0].' '.$testCases[1]);//executing the file with test cases
					$output=shell_exec($command);//gets output
					$output=trim($output);
					if(is_null($output)){
						$score-=$deduct*5;//deducts half credit if it doesn't compile
						$comment=$comment."-".($deduct*5).": Your written code does not compile.\n\n";
					}
					else{
						if($output!==$testCases[2]){
							$score-=$deduct*3;//deducts 2 if it compiles but wrong answer
							$comment=$comment."-".($deduct*3).": Your output is not valid based on the problem requirements.\n\n";
						}
					}
				}
				else if(sizeof($testCases)===2){
					for($i=0; $i<strlen($lines[0]); $i++){
						$ch=substr($lines[0],$i,1);
							if($ch===")" && preg_match($letters,substr($lines[0],$i-1,1))){
								$param=substr($lines[0],$i-1,1);
								break;//gets the parameter variables
							}
					}
					if(empty($param)){
						$score-=$deduct;
						$comment=$comment."-".($deduct*3).": No parameter given.\n";
						$param="n";
					}
					$string=null;
					for($i=0; $i<sizeof($lines); $i++){
						$string=$string.$lines[$i]."\n";
					}//changes the answer to a format that can be compiled
					$shebang="#!/usr/bin/env python\n";//creates the other lines of the code
					$sys="import sys\n";
					$fname="pyfile.py";
					$pyfile=fopen($fname,"w+") or die("didn't work");
					chmod($fname, 0744);
					$line5=$param."=sys.argv[1]\n";
					$line7="c=".$keywords[1]."(int(".$param."))\n";
					$line8="print c";//produces output
					fwrite($pyfile,$shebang);
					fwrite($pyfile,$sys);
					fwrite($pyfile,$string);
					fwrite($pyfile,$line5);
					fwrite($pyfile,$line7);
					fwrite($pyfile,$line8);
					fclose($pyfile);//for writing each line to the file then closing it
					$command=escapeshellcmd('./'.$fname.' '.$testCases[0]);//executing the file with test cases
					$output=shell_exec($command);//gets output
					$output=trim($output);
					if(is_null($output)){
						$score-=$deduct*5;//deducts half credit if it doesn't compile
						$comment=$comment."-".($deduct*5).": Your written code does not compile.\n\n";
					}
					else{
						if($output!==$testCases[1]){
							$score-=$deduct*3;//deducts 2 if it compiles but wrong answer
							$comment=$comment."-".($deduct*3).": Your output is not valid based on the problem requirements.\n\n";
						}
					}
				}
			}
			if($score<1){
				$score=0;
			}
			$comment=$comment."Score for this problem: ".$score."/".$points;
			$final=array($score,$comment);
		}
		return $final;
	}
