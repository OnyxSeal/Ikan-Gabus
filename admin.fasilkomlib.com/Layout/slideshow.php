<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    }

    .bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: -1;
    }

    .bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.2);
    }

    .content-width {
        position: relative;
        z-index: 1;
    }


    html, body {
    width: 100%;
    height: 100vh;
    font-family: 'Fira Mono', monospace;
    -webkit-font-smoothing: antialiased;
    font-size: .88rem;
    color: #bdbdd5;
    }

    .content-width {
    width: 86%;
    height: 100vh;
    margin: 0 auto;
    }

    .slideshow {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    }

    .slideshow-items {
    position: relative;
    width: 100%;
    height: 300px;
    }

    .item {
    position: absolute;
    width: 100%;
    height: auto;
    }

    .item-image-container {
    position: relative;
    width: 42%;
    }

    .item-image-container::before {
    content: '';
    position: absolute;
    top: -1px;
    left: 0;
    width: 101%;
    height: 101%;
    background: #22222A;
    opacity: 0;
    z-index: 1;
    }

    .item-image {
    width: 1175px;
    height: 400px;
    object-fit: cover;
    position: relative;
    opacity: 0;
    display: block;
    /* transition: property name | duration | timing-function | delay  */
    transition: opacity .3s ease-out .45s;
    }

    .item.active .item-image {
    opacity: 1;
    }

    .item.active .item-image-container::before {
    opacity: 0;
    }

    .item-description {
    position: absolute;
    top: 182px;
    right: 0;
    width: 50%;
    padding-right: 4%;
    line-height: 1.8;
    }

    /* Staggered Vertical Items ------------------------------------------------------*/
    .item-header {
    text-shadow: 2px 2px 9px #000000;
    position: absolute;
    top: 150px;
    left: -1.8%;
    z-index: 100;
    }

    .item-header .vertical-part {
    margin: 0 -4px;
    font-family: 'Montserrat', sans-serif;
    -webkit-font-smoothing: auto;
    font-size: 7vw;
    color: #fff;
    }

    .vertical-part {
    overflow: hidden;
    display: inline-block;
    }

    .vertical-part b {
    display: inline-block;
    transform: translateY(100%);
    }

    .item-header .vertical-part b {
    transition: .5s;
    }

    .item-description .vertical-part b {
    transition: .21s;
    }

    .item.active .item-header .vertical-part b {
    transform: translateY(0);
    }

    .item.active .item-description .vertical-part b {
    transform: translateY(0);
    }

    /* Controls ----------------------------------------------------------------------*/
    .controls {
    position: relative;
    text-align: right;
    z-index: 1000;
    }

    .controls ul {
    list-style: none;
    }

    .controls ul li {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 3px;
    background:#bdbdd5;;
    cursor: pointer;
    }

    .controls ul li.active {
    background:#6a6a77;;
    }
</style>
<div class="bg">
    <img src="https://images.pexels.com/photos/1290141/pexels-photo-1290141.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="pustaka">
</div>
<div class="content-width">
    <div class="slideshow">
      <!-- Slideshow Items -->
      <div class="slideshow-items">
        <div class="item">
          <div class="item-image-container">
            <img class="item-image" src="https://images.pexels.com/photos/247899/pexels-photo-247899.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
          </div>
          <!-- Staggered Header Elements -->
          <div class="item-header">
            <span class="vertical-part"><b>M</b></span>
            <span class="vertical-part"><b>e</b></span>
            <span class="vertical-part"><b>m</b></span>
            <span class="vertical-part"><b>b</b></span>
            <span class="vertical-part"><b>a</b></span>
            <span class="vertical-part"><b>c</b></span>
            <span class="vertical-part"><b>a</b></span>
          </div>
          <!-- Staggered Description Elements -->
          <div class="item-description">
            <span class="vertical-part"><b>Buku-buku</b></span>
            <span class="vertical-part"><b>dapat</b></span>
            <span class="vertical-part"><b>mengembangkan</b></span>
            <span class="vertical-part"><b>kecerdasan,</b></span>
            <span class="vertical-part"><b>membina</b></span>
            <span class="vertical-part"><b>watak,</b></span>
            <span class="vertical-part"><b>dan</b></span>
            <span class="vertical-part"><b>bahkan</b></span>
            <span class="vertical-part"><b>mengubah</b></span>
            <span class="vertical-part"><b>dunia,</b></span>
            <span class="vertical-part"><b>tetapi</b></span>
            <span class="vertical-part"><b>tanpa</b></span>
            <span class="vertical-part"><b>dibaca,</b></span>
            <span class="vertical-part"><b>buku</b></span>
            <span class="vertical-part"><b>itu</b></span>
            <span class="vertical-part"><b>tiada</b></span>
            <span class="vertical-part"><b>artinya.</b></span>
        </div>

        </div>
        <div class="item">
          <div class="item-image-container">
            <img class="item-image" src="https://images.pexels.com/photos/1106468/pexels-photo-1106468.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
          </div>
          <!-- Staggered Header Elements -->
          <div class="item-header">
            <span class="vertical-part"><b>T</b></span>
            <span class="vertical-part"><b>a</b></span>
            <span class="vertical-part"><b>n</b></span>
            <span class="vertical-part"><b>p</b></span>
            <span class="vertical-part"><b>a</b></span>
            <span class="vertical-part"><b>&nbsp;</b></span>
            <span class="vertical-part"><b>B</b></span>
            <span class="vertical-part"><b>a</b></span>
            <span class="vertical-part"><b>t</b></span>
            <span class="vertical-part"><b>a</b></span>
            <span class="vertical-part"><b>s</b></span>
        </div>
          <!-- Staggered Description Elements -->
          <div class="item-description">
            <span class="vertical-part"><b>Membaca</b></span>
            <span class="vertical-part"><b>adalah</b></span>
            <span class="vertical-part"><b>perjalanan</b></span>
            <span class="vertical-part"><b>tanpa</b></span>
            <span class="vertical-part"><b>batas.</b></span>
            <span class="vertical-part"><b>Menjelajah</b></span>
            <span class="vertical-part"><b>waktu</b></span>
            <span class="vertical-part"><b>dan</b></span>
            <span class="vertical-part"><b>ruang,</b></span>
            <span class="vertical-part"><b>tiketmu</b></span>
            <span class="vertical-part"><b>untuk</b></span>
            <span class="vertical-part"><b>pengetahuan</b></span>
            <span class="vertical-part"><b>baru.</b></span>
          </div>

        </div>
        <div class="item">
          <div class="item-image-container">
            <img class="item-image" src="https://images.pexels.com/photos/1326947/pexels-photo-1326947.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
          </div>
          <!-- Staggered Header Elements -->
          <div class="item-header">
          <span class="vertical-part"><b>R</b></span>
          <span class="vertical-part"><b>a</b></span>
          <span class="vertical-part"><b>j</b></span>
          <span class="vertical-part"><b>i</b></span>
          <span class="vertical-part"><b>n</b></span>
          <span class="vertical-part"><b>&nbsp;</b></span>
          <span class="vertical-part"><b>B</b></span>
          <span class="vertical-part"><b>e</b></span>
          <span class="vertical-part"><b>l</b></span>
          <span class="vertical-part"><b>a</b></span>
          <span class="vertical-part"><b>j</b></span>
          <span class="vertical-part"><b>a</b></span>
          <span class="vertical-part"><b>r</b></span>
          </div>
          <!-- Staggered Description Elements -->
          <div class="item-description">
              <span class="vertical-part">
                  <b>Berhentilah</b>
              </span>
              <span class="vertical-part">
                  <b>menunggu</b>
              </span>
              <span class="vertical-part">
                  <b>waktu</b>
              </span>
              <span class="vertical-part">
                  <b>yang</b>
              </span>
              <span class="vertical-part">
                  <b>tepat,</b>
              </span>
              <span class="vertical-part">
                  <b>karena</b>
              </span>
              <span class="vertical-part">
                  <b>waktu</b>
              </span>
              <span class="vertical-part">
                  <b>yang</b>
              </span>
              <span class="vertical-part">
                  <b>tepat</b>
              </span>
              <span class="vertical-part">
                  <b>tidak</b>
              </span>
              <span class="vertical-part">
                  <b>akan</b>
              </span>
              <span class="vertical-part">
                  <b>pernah</b>
              </span>
              <span class="vertical-part">
                  <b>datang.</b>
              </span>
              <span class="vertical-part">
                  <b>Mulailah</b>
              </span>
              <span class="vertical-part">
                  <b>belajar</b>
              </span>
              <span class="vertical-part">
                  <b>sekarang</b>
              </span>
              <span class="vertical-part">
                  <b>juga.”</b>
              </span>
              <span class="vertical-part">
                  <b>-</b>
              </span>
              <span class="vertical-part">
                  <b>Roy</b>
              </span>
              <span class="vertical-part">
                  <b>T.</b>
              </span>
              <span class="vertical-part">
                  <b>Bennett</b>
              </span>
          </div>

        </div>
      </div>
      <div class="controls">
        <ul>
          <li class="control" data-index="0"></li>
          <li class="control" data-index="1"></li>
          <li class="control" data-index="2"></li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    // Master DOManipulator v2 ------------------------------------------------------------
    const items = document.querySelectorAll('.item'),
    controls = document.querySelectorAll('.control'),
    headerItems = document.querySelectorAll('.item-header'),
    descriptionItems = document.querySelectorAll('.item-description'),
    activeDelay = .76,
    interval = 5000;

    let current = 0;

    const slider = {
    init: () => {
        controls.forEach(control => control.addEventListener('click', (e) => { slider.clickedControl(e) }));
        controls[current].classList.add('active');
        items[current].classList.add('active');
    },
    nextSlide: () => { // Increment current slide and add active class
        slider.reset();
        if (current === items.length - 1) current = -1; // Check if current slide is last in array
        current++;
        controls[current].classList.add('active');
        items[current].classList.add('active');
        slider.transitionDelay(headerItems);
        slider.transitionDelay(descriptionItems);
    },
    clickedControl: (e) => { // Add active class to clicked control and corresponding slide
        slider.reset();
        clearInterval(intervalF);

        const control = e.target,
        dataIndex = Number(control.dataset.index);

        control.classList.add('active');
        items.forEach((item, index) => { 
        if (index === dataIndex) { // Add active class to corresponding slide
            item.classList.add('active');
        }
        })
        current = dataIndex; // Update current slide
        slider.transitionDelay(headerItems);
        slider.transitionDelay(descriptionItems);
        intervalF = setInterval(slider.nextSlide, interval); // Fire that bad boi back up
    },
    reset: () => { // Remove active classes
        items.forEach(item => item.classList.remove('active'));
        controls.forEach(control => control.classList.remove('active'));
    },
    transitionDelay: (items) => { // Set incrementing css transition-delay for .item-header & .item-description, .vertical-part, b elements
        let seconds;
        
        items.forEach(item => {
        const children = item.childNodes; // .vertical-part(s)
        let count = 1,
            delay;
        
        item.classList.value === 'item-header' ? seconds = .015 : seconds = .007;

        children.forEach(child => { // iterate through .vertical-part(s) and style b element
            if (child.classList) {
            item.parentNode.classList.contains('active') ? delay = count * seconds + activeDelay : delay = count * seconds;
            child.firstElementChild.style.transitionDelay = `${delay}s`; // b element
            count++;
            }
        })
        })
    },
    }

    let intervalF = setInterval(slider.nextSlide, interval);
    slider.init();
  </script>