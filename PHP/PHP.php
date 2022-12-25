<!-- 알라딘 API -->
<?php
$ttb = 'ttbjosee0009001';
$http = "http://www.aladin.co.kr/ttb/api/ItemLookUp.aspx?ttbkey=".$ttb."&itemIdType=ISBN&ItemId=".$_isbn.
"&output=js&Version=20131101&OptResult=ebookList,usedList,reviewList";
$data = file_get_contents($http);
$R = json_decode($data,TRUE);
?>

<!-- 카카오 책 검색 -->
<?php
$uri = "https://dapi.kakao.com/v3/search/book?target=isbn&query=".$_isbn;
$REST_API_KEY = "f6673e9d7422d84c42c4ca594b5d536e"; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uri);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$header = "KakaoAK ".$REST_API_KEY; 
$headers = array();
$headers[] = "Authorization: ".$header;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$res = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);
$res = json_decode($res, true);
?>

<!-- 네이버 책 검색 -->
<?php
$url = "https://openapi.naver.com/v1/search/book.json?query=".$_isbn; // naver 책검색 api
$is_post = false;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, $is_post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = array();
$headers[] = "X-Naver-Client-Id: "."PQqV6hUare6T4UyAn008"; //클라이언트 아이디 예시
$headers[] = "X-Naver-Client-Secret: "."LPC12UzscS"; //클라이언트 시크릿 키 예시

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec ($ch);	//응답 값
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //응답 코드

curl_close ($ch);
$result = json_decode($response, true);
?>

<!-- 날짜 계산 -->

<?php
for ($i=1; $i<10; $i++) {
	$theday = date('Y-m-d', strtotime('-'.$i.' day'));
	$twentyday[$i] = $dboms->fetch_list("SELECT * FROM exlis00.exlis00.lt_return_info WHERE lib_code='141083' AND loan_date like '%".$theday."%'");
	if (count($twentyday[$i]) > 10) {
		$thenumber = $i;
		break;
	}
}
$yesterday = date('Y-m-d', strtotime('-'.$thenumber.' day'));
?>

<!-- 변수 만들기 -->
<?php
for ($i=0; $i < 10; $i++) { 
	${'list'.$i} = $i;
	echo ${'list'.$i};
}
?>