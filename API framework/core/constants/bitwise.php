<?php namespace _;

// WILL BE CONVERTED TO A BASE CLASS FOR BITWISE PROPERTY TYPE HANDLING

const
upper	= ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],
lower	= ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],
bitix	= [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63],
bits	= [1,2,4,8,16,32,64,128,256,512,1024,2048,4096,8192,16384,32768,65536,131072,262144,524288,1048576,2097152,4194304,8388608,16777216,33554432,67108864,134217728,268435456,536870912,1073741824,2147483648,4294967296,8589934592,17179869184,34359738368,68719476736,137438953472,274877906944,549755813888,1099511627776,2199023255552,4398046511104,8796093022208,17592186044416,35184372088832,70368744177664,140737488355328,281474976710656,562949953421312,1125899906842624,2251799813685248,4503599627370496,9007199254740992,18014398509481984,36028797018963968,72057594037927936,144115188075855872,288230376151711744,576460752303423488,1152921504606846976,2305843009213693952,4611686018427387904,-9223372036854775808],
masks	= [
	
	'upper'	=> 'A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z',
	'lower'	=> 'a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z',
	'bitix'	=> '0|1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63',
	'bits'	=> '1|2|4|8|16|32|64|128|256|512|1024|2048|4096|8192|16384|32768|65536|131072|262144|524288|1048576|2097152|4194304|8388608|16777216|33554432|67108864|134217728|268435456|536870912|1073741824|2147483648|4294967296|8589934592|17179869184|34359738368|68719476736|137438953472|274877906944|549755813888|1099511627776|2199023255552|4398046511104|8796093022208|17592186044416|35184372088832|70368744177664|140737488355328|281474976710656|562949953421312|1125899906842624|2251799813685248|4503599627370496|9007199254740992|18014398509481984|36028797018963968|72057594037927936|144115188075855872|288230376151711744|576460752303423488|1152921504606846976|2305843009213693952|4611686018427387904|-9223372036854775808',

],

A=1,
B=2,
C=4,
D=8,
E=16,
F=32,
G=64,
H=128,
I=256,
J=512,
K=1024,
L=2048,
M=4096,
N=8192,
O=16384,
P=32768,
Q=65536,
R=131072,
S=262144,
T=524288,
U=1048576,
V=2097152,
W=4194304,
X=8388608,
Y=16777216,
Z=Y<<1,
AA=Z<<1,
AB=AA<<1,
AC=AB<<1,
AD=AC<<1,
AE=AD<<1,
AF=AE<<1,
AG=AF<<1;