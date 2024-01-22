
## comento 개발 과제 Api

- 본 프로젝트는 comento 면접 과제 api 입니다.
- 본 api 는 Laravel 10.41.0, php 8.2.14 버전으로 개발되었습니다.
- api 서버 실행을 위해 다음의 단계를 따르십시오. (mac의 경우, 서버 구성 전 homebrew를 최신버전으로 업데이트 할 것을 권장합니다.)

```bash
cd comento
composer install
```

composer 설치가 완료되면 로컬 개발 DB 구축을 위해 mysql을 실행하십시오.
(설치는 다음 링크로 이동 -> https://dev.mysql.com/downloads/mysql/)

```bash
mysql.server start
```

mysql이 실행되면 관리자 계정으로 접속 후 'comento' 명으로 데이터베이스를 생성하십시오.

mysql 환경구성은 .env 파일에서 확인 및 수정 가능 합니다.

본 프로젝트는 api 테스트를 위해 회원 가상데이터를 제공합니다. Laravel 마이그레이션을 통해 필요한 테이블과 데이터를 세팅하십시오.

가상데이터는 users 테이블의 데이터만 제공됩니다. 다른 테이블 데이터는 api를 통해 생성하십시오. (DB 구조 및 가상데이터 구성을 database/migration과 database/factories를 참고하십시오.)

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
```

구성이 완료되면 http://127.0.0.1:8000 으로 접속하여 Laravel Framework 메인페이지에 정상적으로 접속되는지 확인하십시오.



## Api 구성

- 본 api는 RESTFul로 구성되어 있습니다.
- 본 api는 회원정보 등록 없이 migration을 통한 가상의 유저데이터를 이용해 개발되었습니다.
- api 인증을 통한 토큰 발급을 위해 login 기능이 구현되어 있습니다. 해당 인증은 DB에서 users 테이블을 조회한 후 임의의 데이터를 통해 로그인 하십시오. (모든 회원 의 비밀번호는 password로 통일되어 있습니다.)
- ex.) login email = natalia@gmail.com, password = password


### - login 
#### method = post
#### uri = /api/login
#### request
- email : string
- password : string

#### response

```code
1|Eh5FMMW9e1WrfYcn6yKtpNwwLXLcLFKDMZm8oyJz738b76c4
```
response로 받은 토큰을 인증이 필요한 api 호출시 해더의 authorization Bearer 값으로 전송하십시오.

ex.) authorization = Bearer 1|Eh5FMMW9e1WrfYcn6yKtpNwwLXLcLFKDMZm8oyJz738b76c4


### - QnA 목록
#### method = get
#### uri = /api/board/list/{page}
#### is_auth = 아니오
#### param
- page : integer

#### response

```code
{
    "message": "success",
    "data": {
        "total_count": 9,
        "list": [
            {
                "idx": 1,
                "title": "고양이가 자꾸 털을 뱉어요 ㅠㅠ",
                "contents": "도와주세요. 감사합니다! 길게 써보겠...",
                "user_idx": 2,
                "reply_count": 2
            },
            {
                "idx": 2,
                "title": "test2",
                "contents": "22222",
                "user_idx": 3,
                "reply_count": 0
            },
            {
                "idx": 3,
                "title": "test3",
                "contents": "3333",
                "user_idx": 2,
                "reply_count": 0
            },
            {
                "idx": 4,
                "title": "test4",
                "contents": "44",
                "user_idx": 3,
                "reply_count": 0
            },
            {
                "idx": 5,
                "title": "test5",
                "contents": "55",
                "user_idx": 2,
                "reply_count": 0
            },
            {
                "idx": 6,
                "title": "test6",
                "contents": "666",
                "user_idx": 3,
                "reply_count": 0
            }
        ]
    }
}
```


### - QnA 본문
#### method = get
#### uri = /api/board/view/{idx}
#### is_auth = 아니오
#### param
- idx : integer

#### response

```code
{
    "message": "success",
    "data": {
        "content": [
            {
                "idx": 1,
                "title": "고양이가 자꾸 털을 뱉어요 ㅠㅠ",
                "contents": "도와주세요. 감사합니다! 길게 써보겠습니다. 20글자 넘어야 하거든요. 어디까지 나오나 실험해 봅시다!",
                "user_idx": 2,
                "created_at": "2024-01-21 18:54:36",
                "updated_at": "2024-01-22 11:39:56"
            }
        ],
        "reply": [
            {
                "idx": 2,
                "contents": "일반적으로 정상입니다. 청결을 유지해 주세요^^",
                "choice_status": 1,
                "rel_board_idx": 1,
                "user_idx": 8,
                "created_at": "2024-01-21 19:23:06",
                "updated_at": "2024-01-22 04:13:41",
                "deleted_at": null
            },
            {
                "idx": 3,
                "contents": "api 입력 테스트",
                "choice_status": 1,
                "rel_board_idx": 1,
                "user_idx": 2,
                "created_at": "2024-01-22 04:16:47",
                "updated_at": "2024-01-22 04:16:47",
                "deleted_at": null
            }
        ]
    }
}
```


### - QnA 등록
#### method = post
#### uri = /api/board/create
#### is_auth = 예
#### param
- title : string
- contents : string

#### response

```code
{
    "message": "success",
    "data": null
}
```


### - QnA 답변 등록
#### method = post
#### uri = /api/board/reply/create
#### is_auth = 예
#### param
- contents : string
- rel_board_idx : integer

#### response

```code
{
    "message": "success",
    "data": null
}
```


### - QnA 답변 채택
#### method = put
#### uri = /api/board/reply/choice
#### is_auth = 예
#### param
- idx : integer (qna_board_reply - idx)

#### response

```code
{
    "message": "success",
    "data": null
}
```


### - QnA 답변 삭제
#### method = delete
#### uri = /api/board/reply/delete/{idx}
#### is_auth = 예
#### param
- idx : integer (qna_board_reply - idx)

#### response

```code
{
    "message": "success",
    "data": null
}
```
