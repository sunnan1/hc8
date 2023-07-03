<?php namespace _;

const
api_version		= '1.0.0',

db_user	    	= 'a585144_homecare_dev',
db_pass	    	= '?nnKtuqlVD_pwWQ265',
db_name			= 'a585144_hc8',
db_host			= 'localhost',


auth_key		= ',fQT:qA 1vh/i8l]|<cTpS8%Wk-Lc!-|4{7=GDUX`2?qhggIWza5!@] TNnTde{}',
secure_key		= '5`/R6!2aLo*}LGFpFtp)7w_$~*o4934Kcf|}azy3]NBUdW-Ml =,3?*R#DJxR2n+',
login_key		= 'cM4NL*}ZN&PGHpj&Ue*.s:[=^y2[]Z-({k64;`NFT=-&.AI&{v{NQ>D&:YPK[w;I',
nonce_key		= 'Us9;RenUMX|]ik>NNx18z{{|#XBs0] RfuH+21`P*Bj;_LBO-*={N_QUWB)CIx=@',
auth_salt		= 'o91WC##R1KtPZ3_X,?lN%cfJ)@9PCC&y`_3*A(2x0K|P{IRZ:+6WglFZKb1 i>bS',
secure_salt		= 'BQ{-vi=>MHiD+HzVz-Z]N|?`;!IUa2{Nm`JA1%I@M14fi1x8<N@R4&O3c<^hJYzJ',
login_salt		= 'T1-Z81:S;+wz3?D%}]f<|9%Dv-{?5rQ4w{f:d:c]Q2=}L9}|qrUpShOp`4+9:&l|',
nonce_salt		= 'nf03-Y0`/]7,A<oWLUC#+3/bB5HW46l9bFN;69oxy+j@F-:U-aV2,O)DXQ#13849',

ukeys 			= [ auth=>auth_key,secure=>secure_key,login=>login_key,nonce=>nonce_key ],
usalts 			= [ auth=>auth_salt,secure=>secure_salt,login=>login_salt,nonce=>nonce_salt ],

languages		= ['en','de'],
hmac_algos		= ['md2','md4','md5','sha1','sha224','sha256','sha384','sha512/224','sha512/256','sha512','sha3-224','sha3-256','sha3-384','sha3-512','ripemd128','ripemd160','ripemd256','ripemd320','whirlpool','tiger128,3','tiger160,3','tiger192,3','tiger128,4','tiger160,4','tiger192,4','snefru','snefru256','gost','gost-crypto','haval128,3','haval160,3','haval192,3','haval224,3','haval256,3','haval128,4','haval160,4','haval192,4','haval224,4','haval256,4','haval128,5','haval160,5','haval192,5','haval224,5','haval256,5'];
