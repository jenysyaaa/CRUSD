<?php

return [
    'perk' => [
        'activation' => 'Активация перка затратит 1 очко Голоса, оно будет снято автоматически.',
        'deactivation' => 'Перк будет деактивирован, и чтобы активировать его снова, придётся затратить 1 очко Голоса.',
    ],
    'character' => [
        'delete' => 'Персонаж будет удалён лишь через некоторое время. Удаление можно будет отменить.',
        'force_delete' => 'Это действие необратимо, персонаж будет удалён окончательно.',
        'cancel' => 'Повторная подача на проверку переместит персонажа в конец очереди.',
        'cancel_approval' => 'Игрок будет уведомлён о том, что его персонажа сняли с проверки.',
        'approval' => 'После одобрения игрок не сможет изменить параметры своего персонажа.',
        'reapproval' => 'Отправка персонажа на перепроверку заблокирует игровой аккаунт.',
        'name' => 'Это имя будет отображаться на странице персонажа. Нежелательно брать нечто слишком длинное.',
        'gender' => 'Всё что не Мужской или Женский - в Другое.',
        'race' => 'Наименование расы персонажа. Ни на какие эффекты не влияет, а расовые особенности реализуются с помощью перков.',
        'age' => 'Не младше 18 лет, но можно отыгрывать "взрослого" ребёнка и девочек возрастом в сотню лет.',
        'description' => '1-2 предложения, характеризующих персонажа в целом, а не только его внешность.',
        'info_hidden' => 'Указанная выше информация, кроме имени, будет скрыта и видна лишь Вам и ГМам. Уберите галочку, если хотите всё это раскрыть.',
        'reference' => 'Арт, картинка, изображение-референс персонажа, отображающее его внешность. Эротическое содержание запрещено.',
        'appearance' => 'Текстовое описание внешности персонажа. Можно указывать актуальные изменения. Не заполняйте слишком уж подробно.',
        'personality' => 'Описание личности, черт характера персонажа, его мотивации, особенностей и прочего.',
        'background' => 'Предыстория персонажа, кем он был, как стал тем, кто он есть. Хватит 1-2 абзацев, не гонитесь за размером, квенты всё равно никто, кроме регистраоров, не читает.',
        'bio_hidden' => 'Указанная информация в поле биографии будет скрыта и видна лишь Вам и ГМам. Уберите галочку, если хотите всё это раскрыть.',
        'player_only_info' => 'Поле для пунктов, которым не нашлось места в полях выше. Может использоваться для артефактов, скрытых перков или чего-то подобного. Будет видно лишь Вам и ГМам.',
        'gm_only_info' => 'Это поле видно лишь ГМам, даже сам игрок его не видит. Используйте для каких-то пометок касательно этого персонажа.',
        'login' => 'Техническое имя персонажа, которое будет использоваться в командах. Должно соответствовать имени персонажа. Только на латинице и без использования нижних подчеркиваний или пробелов. В игре можно будет скрыть, заменив нормальным именем на кириллице. ВНИМАНИЕ: После создания персонажа изменить логин уже нельзя!',
        'skills' => 'Не забывайте про штрафы от низких навыков. Не рекомендуется брать больше 2-3 штрафных навыков в целом.',
        'crafts' => 'Очки Магии получаются от навыка Магии. Техники - от навыка Техники. Общие ремесла могут покупаться за оба типа очков. Третий тир даёт бесплатное ремесло 3-го тира, не забудьте.',
        'narrative_crafts' => 'За каждые 2 очка в Технике или Магии персонаж получает бесплатное нарративное ремесло. Можно покупать за нераспределенные очки с ремёсел выше.',
        'perks' => 'Если перк предполагает какой-то выбор, то укажите его в примечании. Если цена может варьироваться - добавьте ее в поле доп. цены. Активация перков позволяет выбрать, какие перки будут активными со старта, а какие деактивированными.',
        'fates' => 'Не забудьте почитать правила Судеб на нашей вики. Вкратце - это цели, которые ставит себе персонаж. Для двойственной судьбы прожмите галочки Порок и Амбиция. Если не стоит галочка Постоянной судьбы, то судьба считается Разовой',
    ],
    'skins' => [
        'prefix' => 'Скин без префикса является скином по умолчанию. Скины с префиксами можете использовать для смены их в игре, с помощью MorePlayerModels.',
        'skin' => 'Только в .png. Можно не только 64х, но и 128х, 256х, 512х. Больше не стоит, правда.',
        'default' => 'Вам нужен хотя бы один скин без префикса. Он считается скином по умолчанию, который будет прогружаться, если другие скины слетят / не прогрузятся.'
    ]
];
