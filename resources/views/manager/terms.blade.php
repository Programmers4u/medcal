@extends('layouts.app')
@section('css')
@parent
<style>
    .agreement {
        border: 1px black;
        border-radius: 10px;
        width: 100%;
        background-color: white;
        color: black;
        padding: 1em;
        line-height: 1.6em;
        margin-bottom: 1em;
        max-height: 30em;
        overflow: scroll;
    }
    .agreement p, h1 {
        padding-top: .5em;
        padding-bottom: .5em;
        font-weight: 600;
        text-align: center;
    } 
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="agreement">
        <h1>REGULAMIN I UMOWA APLIKACJI MEDCAL</h1>
        <p>§1. POSTANOWIENIA OGÓLNE</p>
        <ol>
            <li>Niniejszy Regulamin i Umowa aplikacji MedCal stosuje się do usług świadczonych przez firmę FineGroup Anna Nowocin, za pośrednictwem aplikacji MedCal (Oprogramowanie), dostępnej w Serwisie www.medcal.pl.</li>
            <li>Serwis i Oprogramowanie są przeznaczone dla podmiotów wykonujących  czynności w zakresie świadczeń zdrowotnych, świadczących usługi zdrowotne, medyczne lub paramedyczne, w szczególności przychodni, lekarzy i pielęgniarek i innych specjalistów, wykonujących swoją działalność w dopuszczalnej na podstawie odrębnych przepisów formie organizacyjno-prawnej. Usługodawca wyłącza możliwość bezpośredniego korzystania z jego Usług przez konsumentów w rozumieniu art. 22(1) Ustawy z dnia 23 kwietnia 1964 r. - Kodeks cywilny</li>
            <li>Definicje:</li>
            <ol>
                <li>Błąd krytyczny – błąd systemu, którego skutkiem jest całkowite zatrzymanie pracy Oprogramowania lub zmiana funkcjonalności jednego lub więcej modułów Oprogramowania w sposób uniemożliwiający korzystanie z Oprogramowania.</li>
                <li>Cennik – wykaz uwzględniający rodzaj i wysokość opłat, związanych z korzystaniem z Oprogramowania, opublikowany na stronie www.medcal.pl. Cennik stanowi integralną część zawieranej Umowy oraz Załącznik nr 1 do niniejszego Regulaminu i Umowy aplikacji MedCal.</li>
                <li>Formularz rejestracji – dostępny w Serwisie internetowym formularz, umożliwiający utworzenie Konta.</li>
                <li>Konto – oznaczony indywidualną nazwą (loginem) i hasłem podanym przez Użytkownika, zbiór zasobów w systemie teleinformatycznym Usługodawcy, w którym gromadzone są dane wprowadzane przez Użytkownika. Dostępne są następujące typy Kont:</li>
                <li>Konto testowe – dotyczy 14 – dniowego okresu testowego z dostępem do funkcji oferowanych przez Usługodawcę w ramach pakietu MedCal z ograniczeniem ilości dostępnych SMS. Zakres funkcji może być ograniczony przez Usługodawcę. Konto testowe po zakończeniu okresu testowego i nie wykupieniu subskrypcji jest usuwane na wyraźne żądanie Usługobiorcy, które należy wysłać na adres: admin@medcal.pl  W przypadku braku wyraźnego żądania usunięcia Konta, Usługodawca zastrzega sobie możliwość wysyłania informacji na temat Oprogramowania.</li>
                <li>Konto w pakiecie MedCal Free – dotyczy darmowej wersji Konta z dostępem do funkcji oferowanych przez Usługodawcę</li>
                <li>Usługodawca zastrzega sobie możliwość utworzenia dodatkowych typów Kont. Charakterystyka Kont będzie dostępna pod adresem: https://www.medcal.pl</li>
                <li>Okres rozliczeniowy – ściśle określony przedział czasowy, za który dokonywane są płatności za korzystanie z Oprogramowania. Usługodawca zastrzega sobie możliwość zmiany okresu rozliczeniowego dla wybranych pakietów w drodze indywidualnych ustaleń z Usługobiorcą.</li>
                <li>Okres testowy –wskazany przez Usługodawcę okres kolejnych 14 (czternastu) dni, w którym działanie Konta udostępnione jest Usługobiorcy  w sposób bezpłatny.</li>
                <li>Oprogramowanie – Aplikacja MedCal (wraz z całą identyfikacją wizualną, materiałami promocyjnymi i reklamowymi) działająca w modelu SaaS (Software as a Service), opierająca się na pracy w chmurze, zarządzana przez Usługodawcę, który odpłatnie lub nieodpłatnie udostępnia ją Usługobiorcom na urządzeniach komputerowych i mobilnych, służąca w szczególności do obsługi i gromadzenia dokumentacji medycznej w formie elektronicznej. Oprogramowanie jest udostępniane na podstawie akceptacji postanowień Regulaminu i Umowy aplikacji MedCal przez Użytkownika.</li>
                <li>Panel – udostępniony przez Usługodawcę indywidualny panel, zapewniający dostęp do prowadzonego w Serwisie Konta, umożliwiający korzystanie z Oprogramowania.</li>
                <li>Regulamin i Umowa aplikacji MedCal– niniejszy Regulamin i Umowa aplikacji MedCal, udostępniony nieodpłatnie za pośrednictwem Serwisu internetowego www.medcal.pl w formie, która umożliwia jego pobranie, utrwalenie i wydrukowanie, tak aby umożliwić swobodne zapoznawanie się z postanowieniami Regulaminu i Umowy aplikacji MedCal przed ich akceptacją.</li>
                <li>Serwis – strona internetowa prowadzona przez Administratora pod domeną www.medcal.pl.</li>
                <li>Umowa - umowa o świadczenie usług zawierana pomiędzy Usługodawcą  i Usługobiorcą z chwilą akceptacji Regulaminu i Umowy aplikacji MedCal przez Usługobiorcę w momencie zakupu subskrypcji lub wyboru konta w pakiecie MedCal Free, na czas określony 12 miesięcy lub 1 miesiąca – w zależności od wybranej opcji, w języku polskim, o treści odpowiadającej treści Regulaminu i Umowy aplikacji MedCal.</li>
                <li>Usługa – usługa świadczona przez Usługodawcę polegająca na udostępnieniu Usługobiorcy do korzystania Oprogramowania drogą elektroniczną bez konieczności jego instalowania na infrastrukturze Usługobiorcy.</li>
                <li>Usługobiorca – podmiot wykonujący czynności w zakresie świadczeń zdrowotnych, świadczących usługi zdrowotne, medyczne lub paramedyczne (w szczególności przychodnia, lekarz lub pielęgniarka, fizjoterapeuta, rehabilitant i inni specjaliści), który korzysta z usług świadczonych drogą elektroniczną przez Usługodawcę i wykorzystuje odpłatnie udostępnione Oprogramowanie.</li>
                <li>Usługodawca – FineGroup , Warszawa ul. Lektykarska 46, NIP: ………..., REGON: …………., wpisana do Rejestru prowadzonego prze burmistrza Warszawa-Bielany pod numerem: …….., e-mail: admin@medcal.pl, numer tel.: 694 495 342.</li>
                <li>Użytkownik – osoba fizyczna upoważniona przez Usługobiorcę do korzystania z Usługi, której Usługobiorca nadał określone uprawnienia do korzystania z poszczególnych funkcjonalności.</li>
            </ol>
            <li>Usługi świadczone przez Usługodawcę są dostępne 24 godziny na dobę przez 7 dni w tygodniu.
            <li>Usługi świadczone na rzecz Usługobiorcy w ramach Oprogramowania, na podstawie zawieranej odpłatnej Umowy, umożliwiają:
            <ol>
                <li>prowadzenie indywidualnego Konta,</li>
                <li>tworzenie i przechowywanie dokumentacji medycznej w formie elektronicznej, a także w formie papierowej na podstawie wydruków z Serwisu,</li>
                <li>tworzenie terminarza wizyt i powiadomień dla pacjentów,</li>
                <li>korzystanie z innych usług i funkcji dostępnych w Oprogramowaniu, które mogą być regulowane Załącznikami do niniejszego Regulaminu i Umowy aplikacji MedCal,</li>
                <li>wsparcie techniczne działu IT.</li>
            </ol>
        </ol>
        
        <p>§2. ZASADY KORZYSTANIA Z OPROGRAMOWANIA ORAZ SERWISU</p>

        <ol>
            <li>Usługobiorca zobowiązany jest do korzystania z Oprogramowania, w sposób zgodny z obowiązującym prawem, zasadami współżycia społecznego, dobrymi obyczajami oraz niniejszym Regulaminem i Umową aplikacji MedCal.</li>
            <li>Każde działanie Usługobiorcy powinno odbywać się równocześnie z poszanowaniem dla dóbr osób trzecich - zwłaszcza innych Usługobiorców korzystających z Oprogramowania i Serwisu.</li>
            <li>Podczas zakładania Konta w Serwisie obowiązkiem Usługobiorcy jest podanie prawdziwych, zgodnych ze stanem faktycznym danych oraz ich ochrona przed dostępem osób nieuprawnionych</li>	
            <li>Wszelkie działania podjęte z wykorzystaniem loginu i hasła Usługobiorcy traktowane są jako działania Usługobiorcy. Usługobiorca ponosi odpowiedzialność za ujawnienie loginu i hasła podmiotom trzecim. Usługobiorca jest zobowiązany do zmiany hasła nie rzadziej niż co 30 dni.</li>
            <li>Niedozwolone są jakiekolwiek próby wprowadzania do systemu informatycznego szkodliwych danych (oprogramowanie złośliwe w tym wirusy, pliki szpiegujące, „robaki” etc.).</li>
            <li>Dostęp do Oprogramowania jest możliwy na urządzeniu komputerowym lub mobilnym spełniającym następujące warunki techniczne:</li>
            <li>Należy używać jednej z następujących przeglądarek lub nowszych:</li>
            <ul>
                <li>Microsoft Edge,</li>
                <li>Chrome - od wersji 21,</li>
                <li>Mozilla Firefox - od wersji 28,</li>
                <li>Opera - od wersji 12.1,</li>
                <li>Safari - od wersji 6.1.</li>
            </ul>
            <li>Wymagane jest włączenie obsługi:</li>
            <ol>
                <li>Ciasteczek - Cookies - do przechowywania sesji użytkowników,</li>
                <li>JavaScript - wymagany jest do prawidłowego wyświetlania i funkcjonowania interfejsu aplikacji.</li>
                <li>System operacyjny, w którym uruchamiane są przeglądarki internetowe wypisane powyżej nie ma wpływu na działanie aplikacji, o ile spełniony jest punkt 1 oraz 2. Testowane systemy operacyjne to lub nowsze:</li>
                <ul>
                    <li>Windows XP, 7, 8 oraz 10,</li>
                    <li>Mac OS X,</li>
                    <li>Debian 7, 8 oraz 9,</li>
                    <li>Ubuntu 16 oraz 17,</li>
                </ul>
                <li>Minimalne wymagania sprzętowe wynoszą następująco:</li>
                <ul>
                    <li>Procesor Pentium 4 lub nowszy wspierający SSE2 (wszystkie współczesne procesory),</li>
                    <li>512MB pamięci RAM dla systemów 32-bitowych oraz 2GB pamięci RAM dla systemów 64-bitowych,</li>
                    <li>minimum 200 MB wolnego miejsca na dysku do przechowywania danych tymczasowych i ciasteczek.</li>
                    <li>Stałe połączenie do sieci Internet.</li>
                </ul>
            </ol>
        </ol>

        <p>§3. UMOWA O ŚWIADCZENIE USŁUG</p>

        <ol>    
            <li>Aby móc korzystać z Oprogramowania, konieczne jest założenie Konta. Przed założeniem Konta, należy zapoznać się dokładnie z treścią Regulaminu i Umowy aplikacji MedCal oraz zaakceptować jego warunki. Brak akceptacji warunków i zasad Regulaminu i Umowy aplikacji MedCal uniemożliwia korzystanie z Oprogramowania.</li>
            <li>Świadczenie usług przez Usługodawcę na rzecz Usługobiorcy odbywa się na podstawie  Regulaminu i Umowy aplikacji MedCal, Przepisów Kodeksu Cywilnego, Ustawy o świadczeniu usług drogą elektroniczną oraz innych właściwych. Procedurę zawierania Umowy określa niniejszy dokument.</li>
            <li>Usługodawca może uruchomić okres testowy, który służy zapoznaniu się przez Usługobiorcę z funkcjonalnością Oprogramowania. Zakres świadczonych usług w okresie testowym może zostać ograniczony przez Usługodawcę. </li>
            <li>Usługobiorca zobowiązuje się w okresie testowym nie wprowadzać do systemu MedCal żadnych danych osobowych w stosunku, do których posiada status administratora danych osobowych lub podmiot przetwarzający, w tym w szczególności danych osobowych medycznych pacjentów. Usługobiorca akceptując Regulamin i Umowę aplikacji MedCal oświadcza, że wprowadzane do systemu MedCal w okresie testowym dane (za wyjątkiem danych Usługobiorcy i Użytkowników) są fikcyjne i służą jedynie celom przetestowania funkcjonalności systemu MedCal.</li>
            <li>Użytkownik zakładając konto otrzyma automatycznie przygotowaną stronę www na szablonie MedCal celem jej późniejszego uzupełnienia. Katalog wszystkich stron dostępny jest publicznie. W przypadku braku zgody na umieszczenie strony www Użytkownika w katalogu należy wysłać informację na adres: biuro@medcal.pl</li>
            <li>Podstawą do zawarcia Umowy o świadczenie usług jest uprzednie zgłoszenie przez osobę uprawnioną do reprezentacji Usługobiorcy i wypełnienie Formularza rejestracji oraz uzupełnienie danych w profilu poprzez podanie między innymi następujących danych:</li>
            <ul>
                <li>imię i nazwisko,</li>
                <li>pełna nazwa firmy oraz numer NIP i REGON,</li>
                <li>adres siedziby lub zamieszkania,</li>
                <li>adres poczty elektronicznej e-mail oraz numer telefonu kontaktowego,</li>
            </ul>
            <li>Podanie danych przez Usługobiorcę jest równoznaczne ze złożeniem jego oświadczenia o:
            <ul>
                <li>zgodności z prawdą wszelkich danych udostępnionych Usługodawcy,</li>
                <li>zapoznaniu się z treścią dokumentów stanowiących podstawę zawarcia Umowy,</li>
                <li>wyrażeniu zgody na zawarcie Umowy drogą elektroniczną,</li>
                <li>wyrażeniu zgody na otrzymywanie za pośrednictwem korespondencji mailowej, na wskazany adres email, informacji o wszelkich zmianach dotyczących zasad świadczenia usług oraz o wprowadzanych aktualizacjach i nowościach w Serwisie przez Usługodawcę.</li>
            </ul>
            <li>Za chwilę zawarcia Umowy uznaje się dzień, w którym Usługobiorca zakupi subskrypcję lub wybierze pakiet MedCal Free i zaakceptuje postanowienia niniejszego Regulaminu i Umowy aplikacji i serwisu MedCal.</li>
            <li>Usługodawca może rozszerzyć zakres oferowanych usług i wprowadzić w tym celu stosowne zmiany do Regulaminu i Umowy aplikacji MedCal, bez zgody Usługobiorcy. Wprowadzone zmiany nie mogą naruszać uprawnień Usługobiorcy z tytułu praw nabytych.</li>
            <li>W przypadku przejścia z pakietu MedCal Free do pakietu MedCal Plus lub innego, Umowa na pakiet MedCal Free zostaje automatycznie rozwiązana i zawierana jest umowa na warunkach określonych dla pakietu MedCal Plus lub innego w niniejszym Regulaminie i Umowie aplikacji MedCal.</li>
            <li>Usługobiorca oświadcza, że dysponuje zgodą Użytkownika na świadczenie Usług w oparciu o Konto  tego Użytkownika, w tym na udostępnienie wizerunku. </li>
            <li>Usługodawca zastrzega sobie możliwość zawieszenia dostępu Usługobiorcy do Konta Użytkownika, w przypadku, gdy Użytkownik cofnie zgodę na świadczenie Usług w oparciu o jego Konto, O zawieszeniu dostępu do Konta, Usługobiorca zostanie poinformowany drogą poczty elektronicznej na wskazany adres e-mail. Zawieszenie dostępu do Konta z przyczyny wskazanej powyżej nie ma wpływu na wynagrodzenie należne Usługodawcy z tytułu świadczenia Usług.</li>
        </ol>

        <p>§4. OPŁATY</p>
            
        <ol>
            <li>Szczegółowe zasady płatności określa Cennik, stanowiący Załącznik nr 1 do Regulaminu i Umowy aplikacji MedCal będący integralną częścią Umowy. Cennik jest udostępniony również na stronie Serwisu pod adresem: https://www.medcal.pl/cennik</li>
            <li>Opłata pobierana jest od Usługobiorcy, w formie abonamentu, czyli określonej sumy pieniężnej należnej Usługodawcy, w zamian za korzystanie z Oprogramowania przez dany Okres rozliczeniowy.</li>
            <li>W okresie 14 dni od chwili zawarcia Umowy o świadczenie usług Usługobiorca jest uprawniony do bezpłatnego korzystania z Oprogramowania), celem zaznajomienia się z jego użytecznością. Przełączenie Konta z trybu testowego do Konta MedCal Plus lub innego jest równoznaczne z akceptacją przez Usługobiorcę zaprezentowanej formy Oprogramowania z wszystkimi funkcjami wraz z całą identyfikacją wizualną, w tym logo programu. Po okresie testowym Usługobiorca może wybrać darmową wersję Oprogramowania – MedCal Free z funkcjami opisanymi w Cenniku. Usługobiorca w trakcie korzystania z pakietu MedCal Free może w dowolnym momencie  zmienić pakiet MedCal Free na  MedCal Plus lub inny, co wiąże się z zakupem subskrypcji i uiszczeniem opłaty abonamentowej i innych opłat zgodnie z postanowieniami niniejszego Regulaminu i Umowy aplikacji i serwisu MedCal.</li>
            <li>Z uwagi na brak pobierania przez Usługodawcę opłat za korzystanie z Oprogramowania w wersji MedCal Free, Oprogramowanie w wersji MedCal Free udostępniane jest wyłącznie na rzecz Usługobiorcy, który wyraża zgodę na otrzymywanie, za pośrednictwem Oprogramowania, komunikatów elektronicznych wysyłanych przez Usługodawcę. Komunikaty mogą w szczególności polegać na przesyłaniu informacji o charakterze handlowym, informacyjnym, reklamowym w tym reklamy kierowane do osób upoważnionych do wystawiania recept i mogą służyć bezpośrednio lub pośrednio do promowania towarów, usług lub wizerunku Usługodawcy lub innych podmiotów, na zlecenie których działa Usługodawca. Usługobiorca, który nie zgadza się na otrzymywanie takich komunikatów nie może korzystać z Pakietu MedCal Free.</li>
            <li>Usługobiorca może dokonywać rozliczeń abonamentowych w formie comiesięcznych opłat lub w formie jednorazowej opłaty uiszczanej „z góry” za cały okres trwania Umowy.</li>
            <li>Usługobiorca może dokonywać rozliczeń abonamentowych w formie comiesięcznych opłat płatnych z góry, w wysokości określonej w Cenniku i anulować subskrypcję wysyłając rezygnację na adres e-mail biuro@medcal.pl z adresu e-mail Usługobiorcy przed końcem aktualnego okresu subskrypcji. Usługa zostanie anulowana od dnia przypadającego po ostatnim dniu aktualnego okresu subskrypcji, a typ konta zostanie zmieniony na MedCal Free. Powyższy zapis obowiązuje tylko dla zakupu subskrypcji w modelu rozliczeń comiesięcznych.</li>
            <li>Usługobiorca uzyskuje bieżący dostęp do Usług oferowanych przez Usługodawcę od chwili zawarcia Umowy, dopóty uiszcza wymagalne, comiesięczne należności z tytułu faktur VAT wystawianych przez Usługodawcę lub uiścił jednorazową opłatę za cały okres trwania Umowy; powyższe nie dotyczy Konta MedCal Free.</li>
            <li>Usługodawca przewiduje możliwość stosowania rabatów i upustów cenowych.</li>
            <li>Usługobiorca zawierając Umowę z Usługodawcą upoważnia go do wystawiania faktur VAT bez podpisu odbiorcy.</li>
            <li>Za datę zapłaty wynagrodzenia uznaje się dzień wpływu pełnej należności na rachunek bankowy Usługodawcy. Wszelkie dodatkowe opłaty (bankowe i pocztowe) obciążają Usługobiorcę.</li>
            <li>Usługodawca  zastrzega sobie możliwość zmiany Cennika. O zmianach Cennika Usługobiorca będzie każdorazowo informowany. Nowe opłaty abonamentowe będą obowiązywały Usługobiorcę dopiero od następnego okresu abonamentowego. Usługobiorca będzie mógł zrezygnować z korzystania z Oprogramowania w przypadku, gdy nie zaakceptuje nowych opłat. W przypadku rezygnacji z korzystania z Oprogramowania, w związku ze zmianą Cennika, Usługobiorca powinien do końca miesiąca, w którym rozpoczął obowiązywać nowy Cennik, przesłać Usługodawcy za pośrednictwem poczty elektronicznej na adres e-mail biuro@medcal.pl z adresu e-mail Usługobiorcy oświadczenie o wypowiedzeniu Umowy z 1- miesięcznym okresem wypowiedzenia skutecznym na koniec miesiąca kalendarzowego. W okresie wypowiedzenia obowiązuje dotychczasowy Cennik.</li>
            <li>Usługobiorca ma możliwość zakupu pakietów SMS zgodnie z obwiązującym Cennikiem </li>
            <li>Usługodawca umożliwia eksport bazy danych do Oprogramowania. Jednorazowe wykonanie przez Usługodawcę eksportu bazy danych (po raz pierwszy dla danego Usługobiorcy) jest bezpłatne. Koszt kolejnego eksportu bazy danych określa Cennik.</li>
            <li>Usługodawca umożliwia przeprowadzenie szkolenia z zakresu obsługi Oprogramowania. Jednorazowe szkolenie jest bezpłatne. Koszt kolejnego szkolenia określa Cennik.</li>
            <li>Usługodawca umożliwia wgranie załączników do Oprogramowania. Wgranie załączników o łącznej pojemności 1 GB dla danego Konta jest bezpłatne. Koszt kolejnego wgrania załączników o pojemności 1 GB określa Cennik.</li>
            <li>Usługodawca zastrzega sobie możliwość wysyłania powiadomień i monitów dotyczących zaległych płatności.</li>
        </ol>

        <p>§5. ROZWIĄZANIE UMOWY</p>

        <ol>
            <li>Umowa zawierana jest na czas określony 12 (dwunastu) miesięcy i nie może zostać rozwiązana przed jego zakończeniem z wyjątkiem sytuacji opisanych w niniejszym Regulaminie i Umowie aplikacji MedCal.<li>
            <li>Usługodawca przewiduje możliwość wcześniejszego zakończenia umowy dla Usługobiorców spełniających kryteria opisane w §4 pkt 6.</li>
            <li>Jeżeli Umowa nie zostanie wypowiedziana najpóźniej na 30 dni przed końcem okresu jej obowiązywania, zostanie automatycznie przedłużona na czas określony, na jaki pierwotnie została zawarta, zgodnie z aktualnie obowiązującym Cennikiem.</li>
            <li>Oświadczenie o wypowiedzeniu Umowy powinno zostać przesłane Usługodawcy za pośrednictwem poczty elektronicznej na adres: admin@medcal.pl.</li>
            <li>Usługobiorcy przysługuje prawo do rozwiązania Umowy bez zachowania okresu wypowiedzenia w przypadku, gdy nastąpi przerwa w świadczeniu Usług przekraczająca okres 48 h i będąca następstwem okoliczności, za które winę ponosi Usługodawca. Nie dotyczy to sytuacji, w której przerwa w dostępie do Usług jest skutkiem okoliczności o charakterze obiektywnym, niezależnym od Usługodawcy (np. siła wyższa rozumiana jako zdarzenie zewnętrzne, niemożliwe do przewidzenia i którego skutkom nie można zapobiec - katastrofalne działania przyrody, akty władzy ustawodawczej i wykonawczej oraz niektóre zaburzenia życia zbiorowego).</li>
            <li>Usługodawcy przysługuje prawo do rozwiązania Umowy bez zachowania okresu wypowiedzenia w przypadku:</li>
            <ol>
                <li>wskazania przez Usługobiorcę niekompletnych, nieprawidłowych lub fikcyjnych danych w zakresie określonym w niniejszym Regulaminie i Umowie aplikacji MedCal,</li>
                <li>istnienia uzasadnionego podejrzenia wykorzystania Usług świadczonych przez Usługodawcę niezgodnie z ich celem (przeznaczeniem) lub też w sposób naruszający spójność systemu informatycznego Usługodawcy,</li>
                <li>istnienia uzasadnionego podejrzenia wykorzystania Usług świadczonych przez Usługodawcę w sposób skutkujący bezpośrednio lub pośrednio szeroko pojętymi utrudnieniami w swobodnym korzystaniu z zasobów systemowych lub sprzętowych przez innych Usługobiorców.,</li>
                <li>naruszenia przez Usługobiorcę przepisów prawa powszechnie obowiązującego podczas lub w związku z korzystaniem z Oprogramowania,</li>
                <li>naruszenia przez Usługobiorcę praw osób trzecich (osób fizycznych, prawnych, jednostek organizacyjnych nie posiadających osobowości prawnej) podczas lub w związku z korzystaniem z Oprogramowania,</li>
                <li>naruszenia warunków korzystania z Oprogramowania określonych w niniejszym Regulaminie i Umowie aplikacji MedCal.</li>
            </ol>
            <li>Usługodawca zastrzega sobie prawo, do zaprzestania świadczenia Usług, z chwilą nie opłacenia przez Usługobiorcę co najmniej jednej wymagalnej faktury VAT w terminie 14 dni kalendarzowych od daty wystawienia faktury – bez uprzedniego wzywania Usługobiorcy do uiszczenia zaległej należności czy też podjęcia przez Usługodawcę jakichkolwiek innych działań zmierzających do pozyskania zaległej płatności. W powyższej sytuacji Konto nie zostanie trwale usunięte przez Usługodawcę, a jedynie zablokowane.</li>
            <li>Rezygnacja z Umowy przez Usługobiorcę, przed upływem terminu, na jaki Umowa została zawarta, może pociągać za sobą zobowiązanie do pokrycia w całości wszelkich szkód rzeczywistych (damnum emergens), w tym utraconych korzyści (lucrum cessans), jakie poniósł Usługodawca w związku z wcześniejszym rozwiązaniem Umowy, m.in. kosztów związanych z poniesioną pracą oraz wykorzystanymi materiałami, strat oraz innych wydatków poniesionych przez Usługodawcę.</li>
            <li>W przypadku rozwiązania umowy Usługodawca udostępni bezpłatnie Usługobiorcy, w formie rozszyfrowanej i pozwalającej na odczyt za pomocą ogólnodostępnych narzędzi informatycznych kopię bazy danych Konta, zawierającą oryginalną strukturę oraz najnowszą wersję danych, a także dane przechowywane przez Usługobiorcę w postaci plików, na okres 30 dni. W powyższym okresie Usługobiorca ma obowiązek weryfikacji poprawności kopi bazy danych Konta. Po upływie 30 dni Usługodawca zniszczy te dane bezpowrotnie.</li>
        </ol>

        <p>§6. REKLAMACJE</p>
        
        <ol>    
            <li>Usługobiorcy przysługuje prawo składania reklamacji w przypadku:</li>
            <ol>
                <li>niewykonywania usług objętych Umową,</li>
                <li>nienależytego wykonywania usług objętych Umową,</li>
                <li>nieprawidłowości w zakresie określenia wynagrodzenia z tytułu świadczenia usług przez Usługodawcę.</li>
            </ol>
            <li>Usługobiorca jest zobowiązany do złożenia reklamacji w formie pisemnej na adres korespondencyjny Usługodawcy wskazany w niniejszym Regulaminie i Umowie aplikacji MedCal lub drogą poczty elektronicznej za pośrednictwem wiadomości e-mail przesłanej na adres: admin@medcal.pl.</li>
            <li>Zgłoszenie reklamacyjne powinno zawierać następujące informacje:</li>
            <ol>
                <li>nazwa oraz adres siedziby Usługobiorcy,</li>
                <li>określenie nie wykonanej lub nienależycie wykonanej Usługi lub nieprawidłowo określonego wynagrodzenia wraz ze wskazaniem okoliczności uzasadniających zgłoszenie reklamacyjne,</li>
                <li>preferowany przez Usługobiorcę sposób rozstrzygnięcia zgłoszenia reklamacyjnego.</li>
            </ol>
            <li>Jeżeli podane w reklamacji dane lub informacje wymagają uzupełnienia, przed rozpatrzeniem reklamacji Usługodawca zwróci się do składającego reklamację o jej uzupełnienie we wskazanym zakresie.</li>
            <li>Skuteczne wniesienie reklamacji może nastąpić wyłącznie w terminie 7 dni od dnia powzięcia przez Usługobiorcę informacji o okolicznościach uzasadniających reklamację, jednakże nie później niż w terminie 14 dni od ich zaistnienia.</li>
            <li>Dniem złożenia reklamacji jest dzień wpływu do Usługodawcy pisemnego zgłoszenia reklamacyjnego lub wpływ do Usługodawcy wiadomości e-mail, wysłanej drogą poczty elektronicznej.
            Rozstrzygnięcie w przedmiocie reklamacji złożonej przez Usługobiorcę nastąpi w terminie 7 dni od dnia zgłoszenia.</li>
            <li>Odpowiedź na reklamację wysyłana jest wyłącznie na adres e-mail, chyba że Usługobiorca zgłosi chęć otrzymania odpowiedzi drogą pocztową.</li>
            <li>Za pośrednictwem adresu e-mail: admin@medcal.pl można zgłaszać wszelkie treści i działania, które w jakikolwiek sposób naruszają postanowienia niniejszego Regulaminu i Umowy aplikacji MedCal.</li>
            <li>Błędy krytyczne usuwane będą przez Usługodawcę w terminie 3 dni roboczych od momentu zgłoszenia błędu przez Usługobiorcę. Usługobiorca zgłasza fakt zauważenia Błędu krytycznego za pośrednictwem korespondencji e-mail na adres: biuro@medcal.pl.</li>
            <li>W przypadku wykrycia błędów w działaniu Oprogramowania innych niż Błąd krytyczny Usługobiorcy przysługuje prawo żądania ich usunięcia w odpowiednim terminie, uzależnionym od charakteru i stopnia skomplikowania błędu, jednak  nie dłuższym niż 30 dni od momentu zgłoszenia błędu przez Usługobiorcę. Usługobiorca zgłasza fakt zauważenia błędu za pośrednictwem korespondencji e-mail na adres: biuro@medcal.pl.</li>
        </ol>    
        
        <p>§7. WYŁĄCZENIE ODPOWIEDZIALNOŚCI</p>
            
        <ol>
            <li>Usługobiorca ponosi wyłączną odpowiedzialność za gromadzenie danych osobowych zgodnie z właściwymi przepisami prawa, za wyjątkiem danych osobowych, do gromadzenia których Usługobiorca upoważnił Usługodawcę.</li>
            <li>Usługobiorca ponosi wyłączną odpowiedzialność za prowadzenie, przechowywanie i udostępnianie dokumentacji medycznej zgodnie z ustawą o prawach pacjenta i rzeczniku prawa pacjenta (w tym rozporządzeń wykonawczych do tej ustawy), ustawą o systemie informacji o ochronie zdrowia oraz innymi przepisami powszechnie obowiązującego prawa.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za umieszczanie przez Usługobiorcę w Oprogramowaniu treści o charakterze erotycznym czy pornograficznym lub naruszających normy prawne, moralne, obrazujących lub propagujących przemoc, nienawiść, dyskryminację (rasową, kulturową, etniczną, religijną lub filozoficzną etc.), naruszających dobra osobiste lub obrażających godność innych osób.</li>
            <li>Wyłącznie Usługobiorca jest odpowiedzialny za wprowadzane do Oprogramowania dane, treści, materiały oraz czynności wykonane w związku z korzystaniem z Oprogramowania, a także za osoby trzecie, które z jego powodu w jakikolwiek sposób uzyskały dostęp do Oprogramowania i danych w nich zawartych. Usługobiorca oświadcza, iż wprowadzane dane wizyty i dane pacjenta są autentyczne pod rygorem odpowiedzialności karnej zgodnie z obowiązującymi przepisami prawa, z zastrzeżeniem danych wprowadzanych przez Pacjentów.</li>
            <li>Wyłącznie Usługobiorca jest odpowiedzialny za treść wiadomości SMS wysyłanych za pomocą Oprogramowania.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za działania Usługobiorcy sprzeczne z Regulaminem i Umową aplikacji MedCal, w szczególności za niedopełnienie przez Usługobiorcę obowiązków, które nakładają na niego właściwe przepisy prawa.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za ewentualne szkody spowodowane podaniem przez Usługobiorcę nieprawdziwych, nieaktualnych lub niepełnych danych.</li>
            <li>Wyłącznie Usługobiorca jest odpowiedzialni za to, w jaki sposób korzysta z udostępnionego mu odpłatnie lub nieodpłatnie Oprogramowania.</li>
            <li>Usługobiorca pobiera oraz uzyskuje wszelkie dane oraz treści dostarczane przez Usługodawcę na własną odpowiedzialność.</li>
            <li>Usługobiorca jest również odpowiedzialny za weryfikację wprowadzanych do Oprogramowania danych – Usługodawca nie ingeruje w treść oraz zakres i rodzaj danych wprowadzanych do Oprogramowania. Usługobiorca odpowiada także za prawidłowe i zgodne z prawem wprowadzanie do gromadzenie w nim wszelkich danych osobowych (tj. w szczególności zbieranie danych osobowych w konkretnych, wyraźnych i prawnie uzasadnionych celach i nieprzetwarzane dalej w sposób niezgodny z tymi celami).</li>
            <li>Usługodawca nie ponosi odpowiedzialności w stosunku do Usługobiorcy za utratę zysków (lucrum cessans) lub jakiekolwiek szkody (damnum emergens), straty pośrednie, koszty i inne należności, jakie Usługobiorca poniósł w związku z wykonywaniem swych obowiązków związanych z realizacją Umowy.</li>
            <li>Korzystając z Oprogramowania, Usługobiorca zwalnia Usługodawcę z odpowiedzialności za utratę danych osobowych osób trzecich, które to dane zostały wprowadzone do Oprogramowania bądź zostały niewłaściwie wykorzystane lub w sposób nieuprawniony ujawnione w związku z brakiem u Usługobiorcy odpowiednich zabezpieczeń przed przejęciem Hasła lub Loginu, bądź udostępnieniem przez Usługobiorcę Konta osobom nieuprawnionym.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za niewykonanie lub nienależyte wykonanie usług przez operatorów telekomunikacyjnych, z którymi Usługobiorca posiada zawarte umowy.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za szkody spowodowane niedziałaniem albo wadliwym działaniem oprogramowania firm trzecich, w tym organów administracji państwowej.</li>
            <li>Usługodawca dołoży wszelkiej staranności, aby strona internetowa Serwisu (www.medcal.pl) i Oprogramowanie (app.medcal.pl) były wolne od błędów i dostęp do nich był bezwzględnie ciągły i nieprzerwany. Nie dotyczy to sytuacji, w której przerwa w dostępie do Usług jest skutkiem okoliczności o charakterze obiektywnym, niezależnym od Usługodawcy (np. siła wyższa rozumiana jako zdarzenie zewnętrzne, niemożliwe do przewidzenia i którego skutkom nie można zapobiec - katastrofalne działania przyrody; akty władzy ustawodawczej i wykonawczej oraz niektóre zaburzenia życia zbiorowego).</li>
            <li>Usługodawca nie ponosi odpowiedzialności w szczególności, za wszelkie działania lub zaniechania Usługobiorcy lub jego pracownika; jakiegokolwiek rodzaju szkody poniesione przez osoby trzecie na skutek działań lub zaniechań Usługobiorcy; przerwania dostarczania, utraty lub uszkodzenia danych; niewykonania lub opóźnienia w dostarczaniu Usług z powodu przyczyn niezależnych od Usługodawcy.</li>
            <li>Usługobiorca będzie odpowiadał jak za własne działanie lub zaniechanie za działania i zaniechania osób, którym przyznał dostęp do Oprogramowania (w tym Użytkowników).</li>
            <li>Usługodawca nie odpowiada za problemy bądź przerwy w działaniu sieci internetowej, które uniemożliwiają Usługobiorcy korzystanie z Oprogramowania. W szczególności Usługodawca nie ponosi odpowiedzialności za straty poniesione przez Usługobiorcę w wyniku utraty danych lub niemożliwości przesyłu danych, które spowodowane były przez przerwy w dostępie do stron internetowych Usługodawcy.</li>
            <li>Usługodawca nie ponosi odpowiedzialności za treść reklam, materiałów informacyjnych lub promocyjnych zamieszczanych w Oprogramowaniu oraz rozsyłanych Użytkownikom w ramach świadczenia przez Usługodawcę usług reklamowych na rzecz innych podmiotów.</li>
            <li>Żadna ze Stron nie ponosi odpowiedzialności za szkody wynikłe wskutek działania siły wyższej.</li>
        </ol>
            
        <p>§8. OCHRONA PRAW AUTORSKICH</p>
        
        <ol>    
            <li>Usługodawca udziela Usługobiorcy niewyłącznej, nieograniczonej terytorialnie licencji na korzystanie z Oprogramowania - na czas trwania Umowy.</li>
            <li>Wszelkie zdjęcia oraz pozostałe materiały (w tym teksty, grafiki, logotypy) zamieszczone na stronie Serwisu internetowego www.medcal.pl należą do Usługodawcy lub zostały użyte za zgodą osób trzecich, posiadających do nich prawa autorskie.</li>
            <li>Każdy Usługobiorca, jak i osoba trzecia mająca dostęp do Serwisu, zobowiązani są do powstrzymywania się od kopiowania, modyfikowania, rozpowszechniania, transmitowania lub wykorzystywania w inny sposób jakichkolwiek treści i baz udostępnionych na stronie Serwisu, za wyjątkiem korzystania z nich w ramach dozwolonego użytku.</li>
            <li>Zabronione jest kopiowanie zdjęć i innych materiałów graficznych oraz stosowanie przedruku tekstów zamieszczonych na stronie Serwisu internetowego www.medcal.pl, w tym ich udostępnianie w Internecie bez pisemnej zgody Usługodawcy lub innej osoby trzeciej, posiadającej do nich prawa autorskie.</li>
            <li>Zabrania się również zewnętrznym podmiotom pobierania zdjęć ze strony Serwisu internetowego www.medcal.pl oraz wykorzystywania ich do celów marketingowych oraz handlowych.</li>
            <li>Wykorzystanie wymienionych powyżej materiałów bez pisemnej zgody Usługodawcy lub innej osoby trzeciej, której przysługują prawa autorskie, jest niezgodne z prawem i może stanowić podstawę do wszczęcia postępowania cywilnego oraz karnego, jeżeli Użytkownik dopuszcza się takiego działania.</li>
        </ol>

        <p>§9. OCHRONA DANYCH OSOBOWYCH</p>
        <ol>    
            <li>Dane osobowe Usługobiorcy przetwarzane są wyłącznie w celu realizacji Umowy, o której mowa w niniejszym Regulaminie i Umowie aplikacji MedCal</li>
            <li>Dane osobowe Usługobiorcy nie będą ujawniane innym osobom lub instytucjom bez jego wyraźnej zgody, chyba że obowiązek przekazania danych osobowych będzie wynikał z powszechnie obowiązujących przepisów prawa.<li>
            <li>Administratorem danych osobowych Usługobiorcy jest FineGroup, adres: Warszawa, ul. Lektykarska 46, wpisana do rejestru przedsiębiorców prowadzonego przez Burmistarza Bielany pod numerem ………….., nr tel. 694 495 342, adres e-mail: admin@medcal.pl</li>
            <li>Administrator będzie przechowywał dane osobowe Usługobiorcy przez okres obowiązywania Umowy i po jej zakończeniu do czasu wykonania wszelkich obowiązków związanych z Umową. </li>
            <li>Usługobiorca ma prawo do żądania od Administratora dostępu do jego danych osobowych, ich sprostowania, usunięcia, ograniczenia przetwarzania, wniesienia sprzeciwu wobec przetwarzania (w określonych w przepisach przypadkach), a także prawo do przenoszenia danych, cofnięcia w dowolnym momencie zgody na przetwarzanie danych przez Administratora (w razie cofnięcia zgody na przetwarzanie danych Administrator nie będzie mógł wykonywać obowiązków wynikających z umowy) oraz wniesienia skargi do organu nadzorczego Prezesa Urzędu Ochrony Danych Osobowych.</li>
            <li>Podanie danych osobowych przez Usługobiorcę jest dobrowolne, a w razie ich niepodania nie będzie możliwe świadczenie usług objętych Umową.</li>
            <li>Administrator nie będzie dokonywał profilowania danych osobowych Usługobiorcy.</li>
            <li>Szczegółowe informacje dotyczące ochrony danych osobowych Usługobiorcy znajdują się w dokumencie Polityka prywatności Serwisu internetowego www.medcal.pl/Privacy-Policy.pdf</li>
        </ol>

        <p>§10. POWIERZENIE PRZETWARZANIA DANYCH OSOBOWYCH</p>

        <ol>    
            <li>Oświadczenia Stron</li>
            <ol>
                <li>Zawarcie Umowy oznacza dla Usługobiorcy, zwanego dalej również Administratorem, konieczność powierzenia Usługodawcy, zwanemu dalej również Podmiotem przetwarzającym, do  przetwarzania danych osobowych należących do osób trzecich (w szczególności pacjentów), wprowadzanych przez Usługobiorcę do Oprogramowania. Powierzenie przetwarzania danych osobowych reguluje „Umowa powierzenia przetwarzania danych”, której postanowienia znajdują się w niniejszym paragrafie.</li>
                <li>Jeżeli w tym paragrafie jest mowa o „Umowie głównej” – należy przez to rozumieć  Umowę, natomiast „Umowa powierzenia” – oznacza umowę dotyczącą powierzenia Usługodawcy do przetwarzania danych osobowych.</li>
                <li>Usługobiorca oświadcza, że jest administratorem wszelkich danych osobowych, które przetwarza lub wprowadza do systemu teleinformatycznego za pośrednictwem Oprogramowania oraz oświadcza, że ww. dane osobowe zgromadził zgodnie z obowiązującymi przepisami prawa.</li>
            </ol>
            <li>Przedmiot powierzenia</li>
            <ol>
                <li>Strony postanawiają, że w celu spełnienia obowiązków wynikających z przepisów prawa, a w szczególności art. 28 ust. 3 RODO, oraz właściwej realizacji postanowień zawartej Umowy głównej, Administrator, powierza Podmiotowi przetwarzającemu do przetwarzania dane osobowe, zgromadzone na udostępnionej Administratorowi przestrzeni Aplikacji MedCal, w ramach świadczonych przez Podmiot przetwarzający Usług, w zakresie określonym niniejszą Umową powierzenia. Dane przechowywane są na monitorowanych 24/7 serwerach znajdujących się w Unii Europejskiej, </li>
                <li>Administrator powierza Podmiotowi przetwarzającemu  do przetwarzania dane osobowe należące do osób trzecich t.j. pacjentów, Użytkowników, personelu medycznego i niemedycznego , za które jest odpowiedzialny na mocy odrębnych przepisów. Administrator niniejszym upoważnia Podmiot przetwarzający do przetwarzania danych osobowych zawartych w prowadzonej przez niego w Oprogramowaniu dokumentacji medycznej w celu wykonywania czynności związanych z utrzymaniem Konta Administratora, przechowywania dokumentacji medycznej, zbierania danych poprzez rejestrację on-line i e-wizytę, przesyłania i odbierania danych między Usługobiorcą a Pacjentem - z wykorzystaniem Formularzy MedSign, udostępniania i pobierania danych z platformy usług publicznych w zakresie ochrony zdrowia oraz w celu zapewnienia bezpieczeństwa Konta Administratora. Podmiot przetwarzający i osoby działające w jego imieniu są zobowiązani do zachowania w tajemnicy wszelkich informacji, które dotyczą pacjentów, a które zostały uzyskane w związku z realizacją Umowy. Tajemnica ta obowiązuje również po śmierci pacjenta.</li>
                <li>Zakres danych osobowych przekazanych przez Administratora do przetwarzania będzie zależał od tego, co Administrator wprowadzi do jego Konta. Dane osobowe wprowadzane przez Administratora mogą obejmować w szczególności dane gromadzone w ramach dokumentacji medycznej tj.:</li>
                <li>oznaczenie pacjenta:</li>
                <ul>
                    <li>nazwisko i imię (imiona);</li>
                    <li>datę urodzenia;<li>
                    <li>oznaczenie płci;<li>
                    <li>adres miejsca zamieszkania (ew. adres zameldowania);</li>
                    <li>PESEL, jeżeli został nadany; w przypadku noworodka – numer PESEL matki, a w przypadku osób, które nie mają nadanego numeru PESEL – rodzaj i numer dokumentu potwierdzającego tożsamość </li>
                    <li>numer telefonu;</li>
                    <li>adres e-mail;</li>
                    <li>w przypadku gdy pacjentem jest osoba małoletnia, całkowicie ubezwłasnowolniona lub niezdolna do świadomego wyrażenia zgody – nazwisko i imię (imiona) przedstawiciela ustawowego oraz adres jego miejsca zamieszkania.</li>
                </ul>
                <li>oznaczenie Użytkownika, personelu medycznego i niemedycznego :
                <ul>
                    <li>imię</li>
                    <li>nazwisko</li>
                    <li>tytuł zawodowy/naukowy</li>
                    <li>specjalizacje</li>
                    <li>numer uprawnień</li>
                    <li>adres e-mail</li>
                    <li>numer telefonu</li>
                    <li>wizerunek </li>
                    <li>doświadczenie</li>
                    <li>data urodzenia (podpis ZUS)</li>
                </ul>
                <li>dane osobowe osób upoważnionych przez Pacjenta:</li>
                <ul>
                    <li>nazwisko i imię, </li>
                    <li>numer telefonu</li>
                    <li>adres e-mail</li>
                </ul>
                <li>Dane osobowe będą przetwarzane przez Podmiot przetwarzający przez okres wykonywania Umowy, aż do czasu usunięcia danych zgodnie z ust. 6 punkt 5niniejszej Umowy powierzenia.</li>
                <li>Podmiot przetwarzający dołoży wszelkich starań, aby powierzenie przetwarzania mu danych osobowych zawartych w Oprogramowaniu i Serwisie, nie spowodowało zakłócenia w udzielaniu przez Administratora świadczeń zdrowotnych, w szczególności Podmiot przetwarzający zapewni, bez zbędnej zwłoki, dostęp do danych zawartych w dokumentacji medycznej gromadzonej w Oprogramowaniu.</li>
            </ol>
            <li>Zobowiązania Stron</li>
            <ol>
                <li>Podmiot przetwarzający oświadcza, że zobowiązuje się do wykorzystania danych osobowych, wyłącznie w zakresie niezbędnym do realizacji Umowy powierzenia i Umowy głównej oraz w celach w nich określonych.
                <li>Podmiot przetwarzający oświadcza, iż stosuje środki bezpieczeństwa spełniające wymogi RODO.</li>
                <li>Podmiot przetwarzający oświadcza, że posiada zasoby infrastrukturalne, doświadczenie, wiedzę oraz wykwalifikowany personel, w zakresie umożliwiającym należyte wykonanie Umowy powierzenia, w zgodzie z obowiązującymi przepisami prawa. W szczególności Podmiot przetwarzający oświadcza, że znane mu są zasady przetwarzania i zabezpieczenia danych osobowych wynikające z  RODO.</li>
                <li>Podmiot przetwarzający przy przetwarzaniu danych osobowych zobowiązany jest stosować środki techniczne i organizacyjne zapewniające ochronę przetwarzanych danych. W związku z tym, iż na podstawie Umowy powierzenia mogą być przetwarzane dane gromadzone w ramach dokumentacji medycznej, Podmiot przetwarzający jest zobowiązany do:</li>
                <ol>
                    <li>zabezpieczenia Oprogramowania przed uszkodzeniem lub utratą zgromadzonych w nim danych</li>
                    <li>utrzymywania integralności metadanych i treści dokumentacji prowadzonej za pomocą Oprogramowaniatj. zabezpieczenie przed wprowadzaniem zmian przez osoby nieupoważnione przez Administratora;</li>
                    <li>zapewnienia stałego dostępu do danych dla Użytkownika i zabezpieczeniu przed dostępem osób nieuprawnionych;</li>
                    <li>identyfikacji osoby dokonującej wpisu do dokumentacji prowadzonej za pomocą Oprogramowania i osoby udzielającej świadczeń zdrowotnych oraz dokumentowanie dokonywanych przez te osoby zmian w tej dokumentacji i metadanych (jeśli w ramach jednego Konta Oprogramowanie wykorzystuje kilka osób, każda z tych osób ma swój login i hasło);</li>
                    <li>przyporządkowania cech informacyjnych dla dokumentacji medycznej tworzonej w ramach Oprogramowania poprzez oznaczenie osoby udzielającej świadczeń zdrowotnych (nazwisko, imię, tytuł zawodowy, uzyskane specjalizacje, numer prawa wykonywania zawodu oraz podpis, który jest weryfikowany za pomocą indywidulanego loginu i hasła);</li>
                    <li>udostępnienia poprzez eksport w postaci elektronicznej dokumentacji albo odpowiedniej części dokumentacji w formacie, w którym jest przetwarzana za pomocą Oprogramowania ( XLS, CSV lub XML);</li>
                    <li>zapewnienia eksportu całości danych w formacie określonym przez przepisy wykonawcze do ustawy o systemie informacji o ochronie zdrowia;</li>
                    <li>zapewnienia funkcjonalności wydruku dokumentacji zgromadzonej w Serwisie:. </li>
                    <li>W ramach zabezpieczenia danych powierzonych do przetwarzania Administrator zobowiązuje się do:</li>
                    <ol>
                        <li>systematycznego dokonywania analizy zagrożeń związanych z przechowywaniem danych w Serwisie, a jeżeli będzie to wymagane dokonanie oceny skutków planowanych operacji przetwarzania dla ochrony danych osobowych;</li>
                        <li>opracowania i stosowania procedur zabezpieczania dokumentacji wytwarzanej w ramach Oprogramowania;</li>
                        <li>stosowania środków bezpieczeństwa adekwatnych do zagrożeń, w tym między innymi szyfrowanie danych osobowych oraz zdolność do szybkiego przywrócenia dostępności danych osobowych i dostępu do nich w razie incydentu fizycznego lub technicznego (backup kartoteki co 30 min);</li>
                        <li>bieżącego kontrolowania funkcjonowania wszystkich organizacyjnych i techniczno-informatycznych sposobów zabezpieczenia, a także okresowego dokonywania oceny skuteczności tych sposobów;</li>
                        <li>przygotowania i realizacji planów przechowywania dokumentacji w długim czasie, w tym jej przenoszenia na nowe informatyczne nośniki danych i do nowych formatów danych, jeżeli tego wymaga zapewnienie ciągłości dostępu do dokumentacji.</li>
                    </ol>
                <li>W miarę możliwości Podmiot przetwarzający pomaga Administratorowi w niezbędnym zakresie wywiązywać się z obowiązków określonych w art. 32-36 Rozporządzenia.</li>
                <li>Podmiot przetwarzający będzie wspomagał Administratora w przypadku, gdy osoba fizyczna, której dane osobowe są przetwarzane za pomocą Oprogramowania, zwróci się do Administratora z wnioskiem, mającym podstawę prawną w powszechnie obowiązujących przepisach, dotyczącym przetwarzanych danych.</li>
                <li>Podmiot przetwarzający udzieli Administratorowi pomocy w kontaktach z właściwym organem nadzoru nad ochroną danych osobowych lub innym organem państwa, w szczególności poprzez dostarczanie, na rozsądne życzenie Użytkownika, niezbędnych informacji i dokumentacji.</li>
                <li>Podmiot przetwarzający zawiadomi, bez zbędnej zwłoki (nie później niż w terminie 48 godzin po stwierdzeniu naruszenia), Administratora o wszelkich naruszeniach bezpieczeństwa danych osobowych, które są przetwarzane na podstawie niniejszej Umowy powierzenia. Administrator we własnym zakresie dokona oceny otrzymanych zawiadomień i samodzielnie powiadomi organy nadzoru oraz osoby fizyczne, których te naruszenia dotyczą. Zawiadomienia, o których mowa w zdaniach poprzednich dokonane będą drogą elektroniczną na adres e-mail Administratora w sposób umożliwiający uzyskanie informacji takich, jak charakter naruszenia, możliwe kategorie i przybliżoną liczbę osób, których dane dotyczą, kategorię i przybliżona liczbę wpisów danych osobowych, których dotyczy naruszenie, możliwe konsekwencję naruszenia, środki zastosowane w celu zaradzenia naruszeniu ochrony danych.</li>
                <li>W celu wykonania obowiązków, o których mowa w punktach poprzednich, Podmiot przetwarzający zobowiązany jest prowadzić dokumentację opisującą sposób przetwarzania danych (rejestr czynności przetwarzania danych osobowych oraz rejestr incydentów i naruszeń bezpieczeństwa ochrony danych osobowych), zobowiązany jest przeprowadzać ocenę wymogu wyznaczenia IOD zgodnie z art. 37 RODO i powiadamiać o jej wyniku Usługobiorcę podając dane kontaktowe IOD. Niezależnie od tego Administrator ma prawo do kontroli zgodności przetwarzanych w Oprogramowaniu danych osobowych z Umową przetwarzania. W tym celu Podmiot przetwarzający udostępni Administratorowi, na jego rozsądne i umotywowane żądanie, wszelkie informacje niezbędne do potwierdzenia zgodności przetwarzania z wymogami Umowy powierzenia oraz wymogami innych przepisów powszechnie obowiązujących.</li>
                <li>Podmiot przetwarzający  nie jest uprawniony do przekazywania danych osobowych osobom trzecim, z wyłączeniem osób współpracujących lub pracujących dla Podmiotu przetwarzającego w ramach utrzymania sprawności i funkcjonalności Oprogramowania. W celu uniknięcia wątpliwości, w imieniu Podmiotu przetwarzającego powierzone dane osobowe mogą przetwarzać wyłącznie osoby, które uprzednio uzyskały od niego pisemne upoważnienie. Każde upoważnienie lub jego cofnięcie Podmiot przetwarzający zobowiązany jest wpisać do „Ewidencji osób upoważnionych do przetwarzania danych osobowych”.</li>
                <li>Podmiot przetwarzający zobowiązany jest do zebrania od swoich pracowników lub współpracowników, przy pomocy których realizować będzie przedmiot niniejszej Umowy powierzenia, oświadczeń o obowiązku zachowania w tajemnicy powierzonych danych osobowych.</li>
                <li>Podmiot przetwarzający zobowiązany jest do przeszkolenia swoich pracowników lub współpracowników w zakresie sposobów zabezpieczenia przetwarzanych danych.</li>
            </ol>
            <li>Współdziałanie stron</li>
            <ol>
                <li>Podczas trwania niniejszej Umowy powierzenia, strony zobowiązują się ściśle współpracować za pośrednictwem wyznaczonych osób, informując się wzajemnie o wszystkich okolicznościach mających lub mogących mieć wpływ na realizację Umowy powierzenia.</li>
            </ol>
            <li>Podpowierzenie danych</li>
            <ol>
                <li>Podpowierzenie danych innemu podmiotowi może nastąpić wyłącznie za uprzednią pisemną zgodą Administratora i zgodnie z obowiązującymi przepisami prawa. Wniosek o wyrażenie zgody, o której mowa w zdaniu poprzednim, powinien być dokonany w formie wiadomości elektronicznej skierowanej do Administratora na adres e-mail Administratora jeszcze przed dalszym powierzeniem Danych Podwykonawcy. Podwykonawca, któremu podpowierzono do dalszego przetwarzania dane, winien spełniać te same gwarancje i obowiązki, jakie zostały nałożone na Podmiot przetwarzający w Umowie powierzenia.</li>
                <li>Podmiot przetwarzający oświadcza, że powierzenie przetwarzania Danych, uregulowane zostanie w stosownych umowach powierzenia, a zakres powierzonych do przetwarzania Danych osobowych i dopuszczalnych czynności przetwarzania przez Podwykonawców i Inne dalsze podmioty przetwarzające będzie adekwatny do określonego w niniejszej Umowie powierzenia celu powierzenia danych, oraz nie będzie wykraczał poza Umowę powierzenia oraz Umowę główną, a dalsze podmioty przetwarzające będą stosowały środki techniczne i organizacyjne zapewniające wystarczający poziom ochrony powierzonych Danych. </li>
                <li>Podmiot przetwarzający ponosi pełną odpowiedzialność wobec Administratora za działania lub zaniechania Podwykonawców i/lub Innych dalszych podmiotów przetwarzających.</li>
                <li>Podmiot przetwarzający zobowiązany jest ujawnić wszystkie dalsze podmioty przetwarzające Dane powierzone niniejszą Umową przez Administratora w prowadzonym rejestrze kategorii czynności przetwarzania.</li>
                <li>Podmiot przetwarzający zapewnia, że będzie korzystał wyłącznie z usług takich dalszych podmiotów przetwarzających, które zapewniają wystarczające gwarancje wdrożenia odpowiednich środków technicznych i organizacyjnych, by przetwarzanie spełniało wymogi RODO oraz przepisów ustawy z dnia 10 maja 2018 r. o ochronie danych osobowych (Dz. U. z 2018 r. poz. 1000)., a także zapewniało ochronę praw osób, których dane dotyczą</li>
                <li>Podmiot przetwarzający zapewni w umowie z dalszym podmiotem przetwarzającym, że na podmiot ten zostaną nałożone obowiązki odpowiadające obowiązkom Administratora określonym w Umowie,  w  szczególności  obowiązek  zapewnienia  wystarczających  gwarancji wdrożenia  odpowiednich  środków  technicznych  i organizacyjnych,  by  przetwarzanie odpowiadało wymogom RODO.</li>
                <li>Podmiot przetwarzający  jest  zobowiązany  poinformować  dalszy podmiot przetwarzający, że informacje, w tym dane osobowe, na temat tego podmiotu przetwarzającego mogą być udostępnione Administratorowi w celu wykonania przez niego uprawnień, o których mowa w zdaniu poprzedzającym.</li>
                <li>Podmiot przetwarzający jest w pełni odpowiedzialny przed Administratorem za spełnienie obowiązków wynikających  z  umowy  powierzenia  zawartej  pomiędzy  Administratorem  a  dalszym podmiotem przetwarzającym. Jeżeli dalszy podmiot przetwarzający nie wywiąże się ze spoczywających na nim obowiązków ochrony danych, pełna odpowiedzialność wobec Administratora za wypełnienie obowiązków tego dalszego podmiotu przetwarzającego spoczywa na  Podmiocie przetwarzającym.</li>
            </ol>
            <li>Odpowiedzialność</li>
            <ol>
                <li>Każda ze Stron odpowiada za szkody wyrządzone drugiej stronie oraz osobom trzecim w związku z wykonywaniem Umowy powierzenia, zgodnie z przepisami ustawy z dnia 23 kwietnia 1964 r– Kodeks cywilny, przepisami Ustawy i RODO oraz zgodnie z postanowieniami niniejszej Umowy powierzenia przetwarzania danych.
                <li>W przypadku szkody spowodowanej umyślnym działaniem Podmiotu przetwarzającego, Podmiot przetwarzający ponosić będzie odpowiedzialność za wszelkie szkody poniesione przez Administratora.</li>
                <li>W przypadku innym niż określonym w pkt 2, Podmiot przetwarzający ponosić będzie odpowiedzialność wyłącznie na zasadzie winy.</li>
                <li>W celu uniknięcia wątpliwości, Podmiot przetwarzający ponosi odpowiedzialność za działania swoich pracowników, podwykonawców i innych osób, przy pomocy których przetwarza powierzone dane osobowe, jak za własne działanie i zaniechanie.</li>
                <li>Czas trwania i wypowiedzenie Umowy powierzenia przetwarzania danych</li>
                <li>Umowa powierzenia zostaje zawarta na czas obowiązywania Umowy głównej.</li>
                <li>Umowa powierzenia ulega rozwiązaniu w momencie rozwiązania Umowy głównej.</li>
                <li>Administrator jest uprawniony do rozwiązania Umowy powierzenia bez wypowiedzenia w przypadku rażącego naruszenia zasad przetwarzania danych osobowych określonych w niniejszej Umowie. osobowych określonych w niniejszej Umowie powierzenia.</li>
                <li>Administrator jest uprawniony do rozwiązania Umowy powierzenia bez wypowiedzenia jeżeli w wyniku kontroli organu odpowiedzialnego za nadzorowanie przetwarzania danych osobowych lub innego organu państwa zostanie ujawnione nieodpowiednie zabezpieczenie danych osobowych zgromadzonych w Oprogramowaniu.</li>
                <li>W przypadku rozwiązania Umowy powierzenia przetwarzania danych, Usługodawca udostępni bezpłatnie Usługobiorcy, w formie rozszyfrowanej i pozwalającej na odczyt za pomocą ogólnodostępnych narzędzi informatycznych kopię bazy danych Konta, zawierającą oryginalną strukturę oraz najnowszą wersję danych, a także dane przechowywane przez Usługobiorcę w postaci plików, na okres 30 dni. W powyższym okresie Usługobiorca ma obowiązek weryfikacji poprawności kopi bazy danych Konta. Po upływie 30 dni Usługodawca zniszczy te dane bezpowrotnie</li>
            </ol>
        </ol>

        <p>§11. POSTANOWIENIA KOŃCOWE</p>
         
        <ol>
            <li>Usługodawca zastrzega sobie prawo do wprowadzenia ograniczeń w korzystaniu ze strony Serwisu internetowego spowodowanych jego serwisem technicznym, pracami konserwacyjnymi lub pracami nad polepszeniem jego funkcjonalności. Jednocześnie Usługodawca zobowiązuje się do dołożenia wszelkich starań, by wspomniane przerwy odbywały się w godzinach nocnych i trwały jak najkrócej.</li>
            <li>Usługodawca zastrzega sobie prawo do zmian w Regulaminie i Umowie aplikacji MedCal. Usługobiorca będzie mógł zrezygnować z korzystania z Serwisu w przypadku, gdy nie zaakceptuje warunków nowego Regulaminu i Umowy aplikacji MedCal. W przypadku rezygnacji z korzystania z Oprogramowania, w związku ze zmianą warunków Regulaminu i Umowy aplikacji MedCal, Usługobiorca powinien do końca miesiąca, w którym rozpoczął obowiązywać nowy Regulamin i Umowa aplikacji MedCal, przesłać Usługodawcy za pośrednictwem poczty elektronicznej na adres e-mail admin@medcal.pl z adresu e-mail Usługobiorcy oświadczenie o wypowiedzeniu Umowy z 1- miesięcznym okresem wypowiedzenia skutecznym na koniec miesiąca kalendarzowego. W okresie wypowiedzenia obowiązuje dotychczas obowiązujący Regulamin i Umowa aplikacji MedCal.</li>
            <li>O każdych zmianach Usługodawca będzie informować na stronie Serwisu z odpowiednim wyprzedzeniem. Zmiany będą wchodzić w życie nie wcześniej niż po 2 dniach od ich ogłoszenia.</li>
            <li>Usługodawca zastrzega sobie prawo do stosowania pouczeń, czasowego zawieszania, a w ostateczności usuwania Konta Usługobiorcy , który mimo stosowania uprzednich ostrzeżeń, swym działaniem łamie postanowienia niniejszego Regulaminu i Umowy aplikacji MedCal, utrudnia korzystanie z Serwisu lub Oprogramowania innym podmiotom lub narusza przepisy powszechnie obowiązującego prawa polskiego.</li>
            <li>Usługodawca ma prawo publikować na swojej stronie internetowej informacje dotyczące Usługobiorców korzystających z Oprogramowania, z tym zastrzeżeniem, że Usługodawca zobowiązuje się do usunięcia tych informacji na indywidualne żądanie Usługobiorcy , którego informacje te dotyczą.</li>
            <li>Usługodawca zobowiązuje się do sprawowania nadzoru nad prawidłowym funkcjonowaniem Oprogramowania, a także do dokonywania niezbędnych aktualizacji.</li>
            <li>Strony zobowiązują się do wzajemnego informowania o każdorazowej zmianie adresu, numeru telefonu i faksu, adresu poczty elektronicznej oraz wszelkich niezbędnych do realizacji Umowy danych. W przypadku uchybienia temu obowiązkowi wszelką korespondencję – w tym fakturę wysłaną na poprzedni adres lub adres poczty elektronicznej, uznaje się za skutecznie doręczoną.</li>
            <li>Wszelkie spory między Usługodawcą, a Usługobiorcą będą rozstrzygane w sposób polubowny.</li>
            <li>W przypadku nierozwiązania sporów na drodze polubownej, między Usługodawcą a Usługobiorcą, sądem właściwym jest Sąd właściwy miejscowo i rzeczowo dla miejsca siedziby Usługodawcy.</li>
            <li>W sprawach nieuregulowanych niniejszym Regulaminem i Umową aplikacji MedCal zastosowanie będą miały przepisy powszechnie obowiązującego prawa polskiego.</li>
            <li>Niniejszy Regulamin obowiązuje od dnia 12.11.2020 r.</li>
        </ol>

    </div>
</div>

{!! Button::success(trans('wizard.user.terms'))
    ->block()
    ->large()
    ->asLinkTo( route('manager.business.register', ['plan' => $plan]) )
!!}

@endsection