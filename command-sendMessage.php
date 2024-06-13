<?php

use server\CurlClient;

require_once 'Config.php';
require_once '../vendor/autoload.php';

$url = 'tt2-ws-push-server-ssh/ws-command/sendMessage';
$query = http_build_query(['user_id' => 1]);
$url .= '?' . $query;

$method = 'POST';
$parameters = 'message=Александр Островский
ГРОЗА
ДРАМА В ПЯТИ ДЕЙСТВИЯХ
ЛИЦА:
Савел Прокофьевич Дико́й, купец, значительное лицо в городе 1.
Борис Григорьевич, племянник его, молодой человек, порядочно образованный.
Марфа Игнатьевна Кабанова (Кабаниха), богатая купчиха, вдова.
Тихон Иваныч Кабанов, ее сын.
Катерина, жена его.
Варвара, сестра Тихона.
Кулигин, мещанин, часовщик-самоучка, отыскивающий перпетуум-мобиле.
Ваня Кудряш, молодой человек, конторщик Дикова.
Шапкин, мещанин.
Феклуша, странница.
Глаша, девка в доме Кабановой.
Барыня с двумя лакеями, старуха 70-ти лет, полусумасшедшая.
Городские жители обоего пола.
Действие происходит в городе Калинове, на берегу Волги, летом. Между 3 и 4 действиями проходит 10 дней.
ДЕЙСТВИЕ ПЕРВОЕ
Общественный сад на высоком берегу Волги; за Волгой сельский вид. На сцене две скамейки и несколько кустов.
Явление первое
Кулигин сидит на скамье и смотрит за реку. Кудряш и Шапкин прогуливаются.
Кулигин (поет). «Среди долины ровныя, на гладкой высоте...» (Перестает петь.) Чудеса, истинно надобно сказать, что чудеса! Кудряш! Вот, братец ты мой, пятьдесят лет я каждый день гляжу за Волгу и все наглядеться не могу.
Кудряш. А что?
Кулигин. Вид необыкновенный! Красота! Душа радуется.
Кудряш. Нешто́!
Кулигин. Восторг! А ты: «нешто́!» Пригляделись вы, либо не понимаете, какая красота в природе разлита.
Кудряш. Ну, да ведь с тобой что толковать! Ты у нас антик, химик!
Кулигин. Механик, самоучка-механик.
Кудряш. Все одно.
Молчание.
Кулигин (показывая в сторону). Посмотри-ка, брат Кудряш, кто это там так руками размахивает?
Кудряш. Это? Это Дико́й племянника ругает.
Кулигин. Нашел место!
Кудряш. Ему везде место. Боится, что ль, он кого! Достался ему на жертву Борис Григорьич, вот он на нем и ездит.
Шапкин. Уж такого-то ругателя, как у нас Савел Прокофьич, поискать еще! Ни за что человека оборвет.
Кудряш. Пронзительный мужик!
Шапкин. Хороша тоже и Кабаниха.
Кудряш. Ну, да та хоть по крайности все под видом благочестия, а этот как с цепи сорвался!
Шапкин. Унять-то ею некому, вот он и воюет!
Кудряш. Мало у нас парней-то на мою стать, а то бы мы его озорничать-то отучили.
Шапкин. А что бы вы сделали?
Кудряш. Постращали бы хорошенько.
Шапкин. Как это?
Кудряш. Вчетвером этак, впятером в переулке где-нибудь поговорили бы с ним с глазу на глаз, так он бы шелковый сделался. А про нашу науку-то и не пикнул бы никому, только бы ходил да оглядывался.
Шапкин. Недаром он хотел тебя в солдаты-то отдать.
Кудряш. Хотел, да не отдал, так это все одно что ничего. Не отдаст он меня: он чует носом-то своим, что я свою голову дешево не продам. Это он вам страшен-то, а я с ним разговаривать умею.
Шапкин. Ой ли!
Кудряш. Что тут: ой ли! Я грубиян считаюсь; за что ж он меня держит? Стало быть, я ему нужен. Ну, значит, я его и не боюсь, а пущай же он меня боится.
Шапкин. Уж будто он тебя и не ругает?
Кудряш. Как не ругать! Он без этого дышать не может. Да не спускаю и я: он — слово, а я — десять; плюнет, да и пойдет. Нет, уж я перед ним рабствовать не стану.
Кулигин. С него, что ль, пример брать! Лучше уж стерпеть.
Кудряш. Ну, вот, коль ты умен, так ты его прежде учливости-то выучи, да потом и нас учи! Шаль, что дочери-то у него подростки, больших-то ни одной нет.
Шапкин. А то что бы?
Кудряш. Я б его уважил. Больно лих я на девок-то!
Проходят Дико́й и Борис. Кулигин снимает шапку.
Шапкин (Кудряшу). Отойдем к стороне: еще привяжется, пожалуй.
Отходят.
Явление второе
Те же, Дико́й и Борис.
Дикой. Баклуши ты, что ль, бить сюда приехал! Дармоед! Пропади ты пропадом!
Борис. Праздник; что дома-то делать!
Дикой. Найдешь дело, как захочешь. Раз тебе сказал, два тебе сказал: «Не смей мне навстречу попадаться»; тебе все неймется! Мало тебе места-то? Куда ни поди, тут ты и есть! Тьфу ты, проклятый! Что ты как столб стоишь-то! Тебе говорят аль нет?
Борис. Я и слушаю, что ж мне делать еще!
Дикой (посмотрев на Бориса). Провались ты! Я с тобой и говорить-то не хочу, с езуитом. (Уходя.) Вот навязался! (Плюет и уходит.)
Явление третье
Кулигин, Борис, Кудряш и Шапкин.
Кулигин. Что у вас, сударь, за дела с ним? Не поймем мы никак. Охота вам жить у него да брань переносить.
Борис. Уж какая охота, Кулигин! Неволя.
Кулигин. Да какая же неволя, сударь, позвольте вас спросить. Коли можно, сударь, так скажите нам.
Борис. Отчего ж не сказать? Знали бабушку нашу, Анфису Михайловну?
Кулигин. Ну, как не знать!
Кудряш. Как не знать!
Борис. Батюшку она ведь невзлюбила за то, что он женился на благородной. По этому-то случаю батюшка с матушкой и жили в Москве. Матушка рассказывала, что она трех дней не могла ужиться с родней, уж очень ей дико казалось.
Кулигин. Еще бы не дико! Уж что говорить! Большую привычку нужно, сударь, иметь.
Борис. Воспитывали нас родители в Москве хорошо, ничего для нас не жалели. Меня отдали в Коммерческую академию, а сестру в пансион, да оба вдруг и умерли в холеру; мы с сестрой сиротами и остались. Потом мы слышим, что и бабушка здесь умерла и оставила завещание, чтобы дядя нам заплатил часть, какую следует, когда мы придем в совершеннолетие, только с условием.
Кулигин. С каким же, сударь?
Борис. Если мы будем к нему почтительны.
Кулигин. Это значит, сударь, что вам наследства вашего не видать никогда.
Борис. Да нет, этого мало, Кулигин! Он прежде наломается над нами, наругается всячески, как его душе угодно, а кончит все-таки тем, что не даст ничего или так, какую-нибудь малость. Да еще станет рассказывать, что из милости дал, что и этого бы не следовало.
Кудряш. Уж это у нас в купечестве такое заведение. Опять же, хоть бы вы и были к нему почтительны, не́што кто ему запретит сказать-то, что вы непочтительны?
Борис. Ну да. Уж он и теперь поговаривает иногда: «У меня свои дети, за что я чужим деньги отдам? Чрез это я своих обидеть должен!»
Кулигин. Значит, сударь, плохо ваше дело.
Борис. Кабы я один, так бы ничего! Я бы бросил все да уехал. А то сестру жаль. Он было и ее выписывал, да матушкины родные не пустили, написали, что больна. Какова бы ей здесь жизнь была, и представить страшно.
Кудряш. Уж само собой. Нешто они обращение понимают?
Кулигин. Как же вы у него живете, сударь, на каком положении?
Борис. Да ни на каком: «Живи, говорит, у меня, делай, что прикажут, а жалованья, что положу». То есть через год разочтет, как ему будет угодно.
Кудряш. У него уж такое заведение. У нас никто и пикнуть не смей о жалованье, изругает на чем свет стоит. «Ты, говорит, почем знаешь, что я на уме держу? Нешто ты мою душу можешь знать! А может, я приду в такое расположение, что тебе пять тысяч дам». Вот ты и поговори с ним! Только еще он во всю свою жизнь ни разу в такое-то расположение не приходил.
Кулигин. Что ж делать-то, сударь! Надо стараться угождать как-нибудь.
Борис. В том-то и дело, Кулигин, что никак невозможно. На него и свои-то никак угодить не могут; а уж где ж мне!
Кудряш. Кто ж ему угодит, коли у него вся жизнь основана на ругательстве? А уж пуще всего из-за денег; ни одного расчета без брани не обходится. Другой рад от своего отступиться, только бы он унялся. А беда, как его поутру кто-нибудь рассердит! Целый день ко всем придирается.
Борис. Тетка каждое утро всех со слезами умоляет: «Батюшки, не рассердите! голубчики, не рассердите!»
Кудряш. Да нешто убережешься! Попал на базар, вот и конец! Всех мужиков переругает. Хоть в убыток проси, без брани все-таки не отойдет. А потом и пошел на весь день.
Шапкин. Одно слово: воин!
Кудряш. Еще какой воин-то!
Борис. А вот беда-то, когда его обидит такой человек, которого он обругать не смеет; тут уж домашние держись!
Кудряш. Батюшки! Что смеху-то было! Как-то его на Волге, на перевозе, гусар обругал. Вот чудеса-то творил!
Борис. А каково домашним-то было! После этого две недели все прятались по чердакам да по чуланам.
Кулигин. Что это? Никак, народ от вечерни тронулся?
Проходят несколько лиц в глубине сцены.
Кудряш. Пойдем, Шапкин, в разгул! Что тут стоять-то?
Кланяются и уходят.
Борис. Эх, Кулигин, больно трудно мне здесь без привычки-то! Все на меня как-то дико смотрят, точно я здесь лишний, точно мешаю им. Обычаев я здешних не знаю. Я понимаю, что все это наше русское, родное, а все-таки не привыкну никак.
Кулигин. И не привыкнете никогда, сударь.
Борис. Отчего же?
Кулигин. Жестокие нравы, сударь, в нашем городе, жестокие! В мещанстве, сударь, вы ничего, кроме грубости да бедности нагольной, не увидите. И никогда нам, сударь, не выбиться из этой коры! Потому что честным трудом никогда не заработать нам больше насущного хлеба. А у кого деньги, сударь, тот старается бедного закабалить, чтобы на его труды даровые еще больше денег наживать. Знаете, что ваш дядюшка, Савел Прокофьич, городничему отвечал? К городничему мужички пришли жаловаться, что он ни одного из них путем не разочтет. Городничий и стал ему говорить: «Послушай, говорит, Савел Прокофьич, рассчитывай ты мужиков хорошенько! Каждый день ко мне с жалобой ходят!» Дядюшка ваш потрепал городничего по плечу, да и говорит: «Стоит ли, ваше высокоблагородие, нам с вами об таких пустяках разговаривать! Много у меня в год-то народу перебывает; вы то поймите: недоплачу я им по какой-нибудь копейке на человека, а у меня из этого тысячи составляются, так оно мне и хорошо!» Вот как, сударь! А между собой-то, сударь, как живут! Торговлю друг у друга подрывают, и не столько из корысти, сколько из зависти. Враждуют друг на друга; залучают в свои высокие-то хоромы пьяных приказных, таких, сударь, приказных, что и виду-то человеческого на нем нет, обличье-то человеческое истеряно. А те им, за малую благостыню, на гербовых листах злостные кляузы строчат на ближних. И начнется у них, сударь, суд да дело, и несть конца мучениям. Судятся-судятся здесь, да в губернию поедут, а там уж их и ждут да от радости руками плещут. Скоро сказка сказывается, да не скоро дело делается; водят их, водят, волочат их, волочат; а они еще и рады этому волоченью, того только им и надобно. «Я, говорит, потрачусь, да уж и ему станет в копейку». Я было хотел все это стихами изобразить...
Борис. А вы умеете стихами?
Кулигин. По-старинному, сударь. Поначитался-таки Ломоносова, Державина... Мудрец был Ломоносов, испытатель природы... А ведь тоже из нашего, из простого звания.
Борис. Вы бы и написали. Это было бы интересно.
Кулигин. Как можно, сударь! Съедят, живого проглотят. Мне уж и так, сударь, за мою болтовню достается; да не могу, люблю разговор рассыпать! Вот еще про семейную жизнь хотел я вам, сударь, рассказать; да когда-нибудь в другое время. А тоже есть что послушать.
Входят Феклуша и другая женщина.
Феклуша. Бла-алепие, милая, бла-алепие! Красота дивная! Да что уж говорить! В обетованной земле живете! И купечество все народ благочестивый, добродетелями многими украшенный! Щедростью и подаяниями многими! Я так довольна, так, матушка, довольна, по горлушко! За наше неоставление им еще больше щедрот приумножится, а особенно дому Кабановых.
Уходят.
Борис. Кабановых?
Кулигин. Ханжа, сударь! Нищих оделяет, а домашних заела совсем.
Молчание.
Только б мне, сударь, перепету-мобиль найти!
Борис. Что ж бы вы сделали?
Кулигин. Как же, сударь! Ведь англичане миллион дают; я бы все деньги для общества и употребил, для поддержки. Работу надо дать мещанству-то. А то руки есть, а работать нечего.
Борис. А вы надеетесь найти перпетуум-мобиле?
Кулигин. Непременно, сударь! Вот только бы теперь на модели деньжонками раздобыться. Прощайте, сударь! (Уходит.)
Явление четвертое
Борис (один). Жаль его разочаровывать-то! Какой хороший человек! Мечтает себе и счастлив. А мне, видно, так и загубить свою молодость в этой трущобе. Уж ведь совсем убитый хожу, а тут еще дурь в голову лезет! Ну, к чему пристало! мне ли уж нежности заводить? Загнан, забит, а тут еще сдуру-то влюбляться вздумал. Да в кого! В женщину, с которой даже и поговорить-то никогда не удастся. (Молчание.) А все-таки нейдет она у меня из головы, хоть ты что хочешь. Вот она! Идет с мужем, ну и свекровь с ними! Ну не дурак ли я! Погляди из-за угла, да и ступай домой. (Уходит.)
С противоположной стороны входят Кабанова, Кабанов, Катерина и Варвара.
Явление пятое
Кабанова, Кабанов, Катерина и Варвара.
Кабанова. Если ты хочешь мать послушать, так ты, как приедешь туда, сделай так, как я тебе приказывала.
Кабанов. Да как же я могу, маменька, вас ослушаться!
Кабанова. Не очень-то нынче старших уважают.
Варвара (про себя). Не уважишь тебя, как же!
Кабанов. Я, кажется, маменька, из вашей воли ни на шаг.
Кабанова. Поверила бы я тебе, мой друг, кабы своими глазами не видала да своими ушами не слыхала, каково теперь стало почтение родителям от детей-то! Хоть бы то-то помнили, сколько матери болезней от детей переносят.
Кабанов. Я, маменька...
Кабанова. Если родительница что когда и обидное, по вашей гордости, скажет, так, я думаю, можно бы перенести! А, как ты думаешь?
Кабанов. Да когда же я, маменька, не переносил от вас?
Кабанова. Мать стара, глупа; ну, а вы, молодые люди, умные, не должны с нас, дураков, и взыскивать.
Кабанов (вздыхая в сторону). Ах ты, господи! (Матери.) Да смеем ли мы, маменька, подумать!
Кабанова. Ведь от любви родители и строги-то к вам бывают, от любви вас и бранят-то, все думают добру научить. Ну, а это нынче не нравится. И пойдут детки-то по людям славить, что мать ворчунья, что мать проходу не дает, со свету сживает. А, сохрани господи, каким-нибудь словом снохе не угодить, ну и пошел разговор, что свекровь заела совсем.
Кабанов. Нешто, маменька, кто говорит про вас?
Кабанова. Не слыхала, мой друг, не слыхала, лгать не хочу. Уж кабы я слышала, я бы с тобой, мой милый, тогда не так заговорила. (Вздыхает.) Ох, грех тяжкий! Вот долго ли согрешить-то! Разговор близкий сердцу пойдет, ну и согрешишь, рассердишься. Нет, мой друг, говори, что хочешь, про меня. Никому не закажешь говорить: в глаза не посмеют, так за глаза станут.
Кабанов. Да отсохни язык...
Кабанова. Полно, полно, не божись! Грех! Я уж давно вижу, что тебе жена милее матери. С тех пор как женился, я уж от тебя прежней любви не вижу.
Кабанов. В чем же вы, маменька, это видите?
Кабанова. Да во всем, мой друг! Мать чего глазами не увидит, так у нее сердце вещун, она сердцем может чувствовать. Аль жена тебя, что ли, отводит от меня, уж не знаю.
Кабанов. Да нет, маменька! что вы, помилуйте!
Катерина. Для меня, маменька, все одно, что родная мать, что ты, да и Тихон тоже тебя любит.
Кабанова. Ты бы, кажется, могла и помолчать, коли тебя не спрашивают. Не заступайся, матушка, не обижу небось! Ведь он мне тоже сын; ты этого не забывай! Что ты выскочила в глазах-то поюлить! Чтобы видели, что ли, как ты мужа любишь? Так знаем, знаем, в глазах-то ты это всем доказываешь.
Варвара (про себя). Нашла место наставления читать.
Катерина. Ты про меня, маменька, напрасно это говоришь. Что при людях, что без людей, я все одна, ничего я из себя не доказываю.
Кабанова. Да я об тебе и говорить не хотела; а так, к слову пришлось.
Катерина. Да хоть и к слову, за что ж ты меня обижаешь?
Кабанова. Экая важная птица! Уж и обиделась сейчас.
Катерина. Напраслину-то терпеть кому ж приятно!
Кабанова. Знаю я, знаю, что вам не по нутру мои слова, да что ж делать-то, я вам не чужая, у меня об вас сердце болит. Я давно вижу, что вам воли хочется. Ну что ж, дождетесь, поживете и на воле, когда меня не будет. Вот уж тогда делайте что хотите, не будет над вами старших. А может, и меня вспомянете.
Кабанов. Да мы об вас, маменька, денно и нощно бога молим, чтобы вам, маменька, бог дал здоровья и всякого благополучия и в делах успеху.
Кабанова. Ну, полно, перестань, пожалуйста. Может быть, ты и любил мать, пока был холостой. До меня ли тебе; у тебя жена молодая.
Кабанов. Одно другому не мешает-с: жена само по себе, а к родительнице я само по себе почтение имею.
Кабанова. Так променяешь ты жену на мать? Ни в жизнь я этому не поверю.
Кабанов. Да для чего же мне менять-с? Я обеих люблю.
Кабанова. Ну да, да, так и есть, размазывай! Уж я вижу, что я вам помеха.
Кабанов. Думайте как хотите, на все есть ваша воля; только я не знаю, что я за несчастный такой человек на свет рожден, что не могу вам угодить ничем.
Кабанова. Что ты сиротой-то прикидываешься! Что ты нюни-то распустил? Ну, какой ты муж? Посмотри ты на себя! Станет ли тебя жена бояться после этого?
Кабанов. Да зачем же ей бояться? С меня и того довольно, что она меня любит.
Кабанова. Как зачем бояться! Как зачем бояться! Да ты рехнулся, что ли? Тебя не станет бояться, меня и подавно. Какой же это порядок-то в доме будет? Ведь ты, чай, с ней в законе живешь. Али, по-вашему, закон ничего не значит? Да уж коли ты такие дурацкие мысли в голове держишь, ты бы при ней-то, по крайней мере, не болтал да при сестре, при девке; ей тоже замуж идти: этак она твоей болтовни наслушается, так после муж-то нам спасибо скажет за науку. Видишь ты, какой еще ум-то у тебя, а ты еще хочешь своей волей жить.
Кабанов. Да я, маменька, и не хочу своей волей жить. Где уж мне своей волей жить!
Кабанова. Так, по-твоему, нужно все лаской с женой? Уж и не прикрикнуть на нее, и не пригрозить?
Кабанов. Да я, маменька...
Кабанова (горячо). Хоть любовника заводи! А! И это, может быть, по-твоему, ничего? А! Ну, говори!
Кабанов. Да, ей-богу, маменька...
Кабанова (совершенно хладнокровно). Дурак! (Вздыхает.) Что с дураком и говорить! только грех один!
Молчание.
Я домой иду.
Кабанов. И мы сейчас, только раз-другой по бульвару пройдем.
Кабанова. Ну, как хотите, только ты смотри, чтобы мне вас не дожидаться! Знаешь, я не люблю этого.
Кабанов. Нет, маменька! Сохрани меня господи!
Кабанова. То-то же! (Уходит.)
Явление шестое
Те же без Кабановой.
Кабанов. Вот видишь ты, вот всегда мне за тебя достается от маменьки! Вот жизнь-то моя какая!
Катерина. Чем же я-то виновата?
Кабанов. Кто ж виноват, я уж не знаю.
Варвара. Где тебе знать!
Кабанов. То все приставала: «Женись да женись, я хоть бы поглядела на тебя, на женатого»! А теперь поедом ест, проходу не дает — все за тебя.
Варвара. Так нешто она виновата! Мать на нее нападает, и ты тоже. А еще говоришь, что любишь жену. Скучно мне глядеть-то на тебя. (Отворачивается.)
Кабанов. Толкуй тут! Что ж мне делать-то?
Варвара. Знай свое дело — молчи, коли уж лучше ничего не умеешь. Что стоишь — переминаешься? По глазам вижу, что у тебя и на уме-то.
Кабанов. Ну, а что?
Варвара. Известно что. К Савелу Прокофьичу хочется, выпить с ним. Что, не так, что ли?
Кабанов. Угадала, брат.
Катерина. Ты, Тиша, скорей приходи, а то маменька опять браниться станет.
Варвара. Ты проворней, в самом деле, а то знаешь ведь!
Кабанов. Уж как не знать!
Варвара. Нам тоже не велика охота из-за тебя брань-то принимать.
Кабанов. Я мигом. Подождите! (Уходит.)
Явление седьмое
Катерина и Варвара.
Катерина. Так ты, Варя, жалеешь меня?
Варвара (глядя в сторону). Разумеется, жалко.
Катерина. Так ты, стало быть, любишь меня? (Крепко целует.)
Варвара. За что ж мне тебя не любить-то!
Катерина. Ну, спасибо тебе! Ты милая такая, я сама тебя люблю до смерти.
Молчание.
Знаешь, мне что в голову пришло?
Варвара. Что?
Катерина. Отчего люди не летают!
Варвара. Я не понимаю, что ты говоришь.
Катерина. Я говорю: отчего люди не летают так, как птицы? Знаешь, мне иногда кажется, что я птица. Когда стоишь на горе, так тебя и тянет лететь. Вот так бы разбежалась, подняла руки и полетела. Попробовать нешто теперь? (Хочет бежать.)
Варвара. Что ты выдумываешь-то?
Катерина (вздыхая). Какая я была резвая! Я у вас завяла совсем.
Варвара. Ты думаешь, я не вижу?
Катерина. Такая ли я была! Я жила, ни об чем не тужила, точно птичка на воле. Маменька во мне души не чаяла, наряжала меня, как куклу, работать не принуждала; что хочу, бывало, то и делаю. Знаешь, как я жила в девушках? Вот я тебе сейчас расскажу. Встану я, бывало, рано; коли летом, так схожу на ключок, умоюсь, принесу с собою водицы и все, все цветы в доме полью. У меня цветов было много-много. Потом пойдем с маменькой в церковь, все и странницы — у нас полон дом был странниц да богомолок. А придем из церкви, сядем за какую-нибудь работу, больше по бархату золотом, а странницы станут рассказывать: где они были, что видели, жития разные, либо стихи поют. Так до обеда время и пройдет. Тут старухи уснуть лягут, а я по саду гуляю. Потом к вечерне, а вечером опять рассказы да пение. Таково хорошо было!
Варвара. Да ведь и у нас то же самое.
Катерина. Да здесь все как будто из-под неволи. И до смерти я любила в церковь ходить! Точно, бывало, я в рай войду, и не вижу никого, и время не помню, и не слышу, когда служба кончится. Точно как все это в одну секунду было. Маменька говорила, что все, бывало, смотрят на меня, что со мной делается! А знаешь: в солнечный день из купола такой светлый столб вниз идет, и в этом столбе ходит дым, точно облака, и вижу я, бывало, будто ангелы в этом столбе летают и поют. А то, бывало, девушка, ночью встану — у нас тоже везде лампадки горели — да где-нибудь в уголке и молюсь до утра. Или рано утром в сад уйду, еще только солнышко восходит, упаду на колена, молюсь и плачу, и сама не знаю, о чем молюсь и о чем плачу; так меня и найдут. И об чем я молилась тогда, чего просила — не знаю; ничего мне не надобно, всего у меня было довольно. А какие сны мне снились, Варенька, какие сны! Или храмы золотые, или сады какие-то необыкновенные, и всё поют невидимые голоса, и кипарисом пахнет, и горы и деревья будто не такие, как обыкновенно, а как на образах пишутся. А то будто я летаю, так и летаю по воздуху. И теперь иногда снится, да редко, да и не то.
Варвара. А что же?
Катерина (помолчав). Я умру скоро.
Варвара. Полно, что ты!
Катерина. Нет, я знаю, что умру. Ох, девушка, что-то со мной недоброе делается, чудо какое-то. Никогда со мной этого не было. Что-то во мне такое необыкновенное. Точно я снова жить начинаю, или... уж и не знаю.
Варвара. Что же с тобой такое?
Катерина (берет ее за руку). А вот что, Варя, быть греху какому-нибудь! Такой на меня страх, такой-то на меня страх! Точно я стою над пропастью и меня кто-то туда толкает, а удержаться мне не за что. (Хватается за голову рукой.)
Варвара. Что с тобой? Здорова ли ты?
Катерина. Здорова... Лучше бы я больна была, а то нехорошо. Лезет мне в голову мечта какая-то. И никуда я от нее не уйду. Думать стану — мыслей никак не соберу, молиться — не отмолюсь никак. Языком лепечу слова, а на уме совсем не то: точно мне лукавый в уши шепчет, да все про такие дела нехорошие. И то мне представляется, что мне самое себя совестно сделается. Что со мной? Перед бедой перед какой-нибудь это! Ночью, Варя, не спится мне, все мерещится шепот какой-то: кто-то так ласково говорит со мной, точно голубит меня, точно голубь воркует. Уж не снятся мне, Варя, как прежде, райские деревья да горы; а точно меня кто-то обнимает так горячо-горячо, и ведет меня куда-то, и я иду за ним, иду...
Варвара. Ну?
Катерина. Да что же это я говорю тебе: ты — девушка.
Варвара (оглядываясь). Говори! Я хуже тебя.
Катерина. Ну, что ж мне говорить? Стыдно мне.
Варвара. Говори, нужды нет!
Катерина. Сделается мне так душно, так душно дома, что бежала бы. И такая мысль придет на меня, что, кабы моя воля, каталась бы я теперь по Волге, на лодке, с песнями, либо на тройке на хорошей, обнявшись...
Варвара. Только не с мужем.
Катерина. А ты почем знаешь?
Варвара. Еще бы не знать!..
Катерина. Ах, Варя, грех у меня на уме! Сколько я, бедная, плакала, чего уж я над собой не делала! Не уйти мне от этого греха. Никуда не уйти. Ведь это нехорошо, ведь это страшный грех, Варенька, что я другова люблю?
Варвара. Что мне тебя судить! У меня свои грехи есть.
Катерина. Что же мне делать! Сил моих не хватает. Куда мне деваться; я от тоски что-нибудь сделаю над собой!
Варвара. Что ты! Что с тобой! Вот погоди, завтра братец уедет, подумаем; может быть, и видеться можно будет.
Катерина. Нет, нет, не надо! Что ты! Что ты! Сохрани господи!
Варвара. Чего ты так испугалась?
Катерина. Если я с ним хоть раз увижусь, я убегу из дому, я уж не пойду домой ни за что на свете.
Варвара. А вот погоди, там увидим.
Катерина. Нет, нет, и не говори мне, я и слушать не хочу!
Варвара. А что за охота сохнуть-то! Хоть умирай с тоски, пожалеют, что ль, тебя! Как же, дожидайся. Так какая ж неволя себя мучить-то!
Входит барыня с палкой и два лакея в треугольных шляпах сзади.
Явление восьмое
Те же и барыня.
Барыня. Что, красавицы? Что тут делаете? Молодцов поджидаете, кавалеров? Вам весело? Весело? Красота-то ваша вас радует? Вот красота-то куда ведет. (Показывает на Волгу.) Вот, вот, в самый омут!
Варвара улыбается.
Что смеетесь! Не радуйтесь! (Стучит палкой.) Все в огне гореть будете неугасимом. Все в смоле будете кипеть неутолимой! (Уходя.) Вон, вон куда красота-то ведет! (Уходит.)
Явление девятое
Катерина и Варвара.
Катерина. Ах, как она меня испугала! я дрожу вся, точно она пророчит мне что-нибудь.
Варвара. На свою бы тебе голову, старая карга!
Катерина. Что она сказала такое, а? Что она сказала?
Варвара. Вздор все. Очень нужно слушать, что она городит. Она всем так пророчит. Всю жизнь смолоду-то грешила. Спроси-ка, что об ней порасскажут! Вот умирать-то и боится. Чего сама-то боится, тем и других пугает. Даже все мальчишки в городе от нее прячутся, — грозит на них палкой да кричит (передразнивая): «Все гореть в огне будете!»
Катерина (зажмуриваясь). Ах, ах, перестань! У меня сердце упало.
Варвара. Есть чего бояться! Дура старая...
Катерина. Боюсь, до смерти боюсь! Все она мне в глазах мерещится.
Молчание.
Варвара (оглядываясь). Что это братец нейдет, вон, никак, гроза заходит.
Катерина (с ужасом). Гроза! Побежим домой! Поскорее!
Варвара. Что ты, с ума, что ли, сошла! Как же ты без братца-то домой покажешься?
Катерина. Нет, домой, домой! Бог с ним!
Варвара. Да что ты уж очень боишься: еще далеко гроза-то.
Катерина. А коли далеко, так, пожалуй, подождем немного; а право бы, лучше идти. Пойдем лучше!
Варвара. Да ведь уж коли чему быть, так и дома не спрячешься.
Катерина. Да все-таки лучше, все покойнее; дома-то я к образам да богу молиться!
Варвара. Я и не знала, что ты так грозы боишься. Я вот не боюсь.
Катерина. Как, девушка, не бояться! Всякий должен бояться. Не то страшно, что убьет тебя, а то, что смерть тебя вдруг застанет, как ты есть, со всеми твоими грехами, со всеми помыслами лукавыми. Мне умереть не страшно, а как я подумаю, что вот вдруг я явлюсь перед богом такая, какая я здесь с тобой, 
после этого разговору-то, вот что страшно. Что у меня на уме-то! Какой грех-то! страшно вымолвить!
Гром.
Ах!
Кабанов входит.
Варвара. Вот братец идет. (Кабанову.) Беги скорей!
Гром.
Катерина. Ах! Скорей, скорей!';

//$parameters = 'message=Александр Островский';

$commandAuthToken = Config::$COMMAND_AUTH_TOKEN;
$headers = [
    "Authorization: Bearer $commandAuthToken"
];

[$curlResult, $responseCode, $curlError] = CurlClient::makeRequest($url, $method, $parameters, $headers);

CurlClient::dump($curlResult, $responseCode, $curlError);