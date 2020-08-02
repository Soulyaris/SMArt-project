<h1>SMArt (Self-Made Art)</h1>
[Link to heroku](http:\\mighty-inlet-74313.herokuapp.com)

## Введение

Проект представляет собой Image-Board для художников любого направления, в том числе и фотографов.

Он позволит пользователю разместить свои работы, а также получить по ним отзывы и оценку по 10-бальной шкале.

Также страница профиля пользователя может быть использована в качестве творческого портфолио.

## Основные участники бизнес-процесса и сущности предметной области

<b>Изображение</b> — это сущность, которую создает пользователь.

Изображение имеет своё название и тэги. Другие пользователи могут оценивать и комментировать изображение.

<b>Пользователь</b> — создатель изображения. Может загружать изображения, оставлять комментарии, ставить оценки, а также изменять и удалять сделанные собой работы.

<b>Администратор</b> — пользователь с расширенными возможностями взаимодействия с системой. Его задача – отслеживание нежелательного контента.

К правам обычного пользователя администратору добавляется возможность совершать действия с работами других пользователей, а также их учетными записями.

## Описание бизнес-процесса

Пользователь заходит на сайт и попадает на главную страницу. Он может просматривать топ работ за всё время, за последние сутки, неделю, месяц, а также новинки. Искать изображения по названию. Фильтровать по категории. Сортировать изображения по рейтингу и времени добавления. Кликнув на изображение, пользователь переходит на его страницу.

Перейдя на страницу пользователей, пользователь может найти по имени профиля любого пользователя и открыть его портфолио.

После авторизации пользователь может прокомментировать изображение, а также поставить ему оценку, а также загрузить собственное изображение.

Администратор после авторизации может просматривать изображения и вносить изменения, при необходимости, сопровождаемые описанием причины изменений.

# Описание системы
## Общие требования

Операции удаления сущностей следует реализовать как обновление одного из атрибутов сущности. То есть фактически удалять данные нельзя.

Удаленные сущности по умолчанию не отображаются.

Пользователь системы должен обязательно подтвердить любую операцию удаления.

Недопустимо хранение паролей без дополнительной обработки алгоритмами шифрования.

## Страница пользователей

На странице пользователей отображается список всех пользователей. При выборе пользователя из списка система позволяет перейти на страницу выбранного пользователя для просмотра, редактирования или удаления.

Также существует возможность создать нового пользователя.

Для каждого пользователя отображается его аватар и имя.

На странице реализована возможность отфильтровать пользователей по имени.

Любой пользователь имеет доступ к этой странице. Операция удаления пользователя доступна только Администратору.

## Страница пользователя

На странице пользователя отображаются следующие данные:
аватар, имя, список работ.

При переходе в режим редактирования отображаются поля: логин, пароль(скрыт), имя, аватар.

Также без возможности редактирования отображаются поля: дата регистрации, статус пользователя (удален или активен).

На странице эльфа отображается список полученных драгоценностей, сгруппированный по типу с указанием количества.

Редактировать данные на этой странице может только пользователь, который просматривает страницу самого себя либо Администратор. Администратор также может изменить статус пользователя.

## Страница добавления изображения

На странице добавления изображения пользователь может ввести название, а также выбрать одну или несколько категорий (до 5).

При нажатии на кнопку “Загрузить изображение”, в системе создаются изображение.

Только авторизованные пользователи имеют доступ к этой странице.

## Страница изображений

На странице изображений отображается список всех изображений в системе.

Для каждого изображения при наведении отображается: название и автор.

Существует возможность применить фильтр и отобразить изображение, которые принадлежат определенной категории или сразу нескольким, а также выбрать из предложенных вкладок: Лучшее за день, Лучшее за неделю, Лучшее за месяц, где будут выводится изображения за определенный период в порядке убывания их рейтинга.

Категории, которым не принадлежат никакие изображения, выводиться не будут.

Существует возможность сортировать изображения по рейтингу или дате добавления.

В списке изображения упорядочены по возрастанию даты добавления.

## Страница настроек системы / графиков

На странице будет доступно: 
<ul>
    <li>добавление новых категорий</li>
    <li>топ самых активных пользователей</li>
    <li>количество просмотров каждого автора</li>
    <li>топ художников с самыми высокими рейтингами</li>
</ul>

## Страница авторизации

Без авторизации пользователь имеет право только просматривать контент.

Для доступа к загрузке изображений, комментированию и проставлению рейтинга, пользователю необходимо авторизоваться.

Для авторизации пользователю необходимо выбрать пункт меню «Авторизация». На странице авторизации пользователю предлагается ввести свой логин и пароль. Только после удачной авторизации пользователь получает доступ к расширенному функционалу и перенаправляется главную страницу.
