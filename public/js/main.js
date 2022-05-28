function mpmod(base, exponent, modulus) {
    if ((base < 1) || (exponent < 0) || (modulus < 1)) {
        return("invalid");
    }
    result = 1;
    while (exponent > 0) {
        if ((exponent % 2) == 1) {
            result = (result * base) % modulus;
        }
        base = (base * base) % modulus;
        exponent = Math.floor(exponent / 2);
    }
    return (result);
}
  
function eulerphi(x) {
    result = 0;
    for (i = 1; i < x; i++) {
        if (isunit(i,x)) {
            result++;
        }
    }
    return (result);
}

var btn = document.querySelector('#btn')
var text = document.querySelector('.content form')
btn.addEventListener('click', () => {
    let a = 5
    let q = 300000000000000000000000000000000000000000000000000000875421845120485120
    let xa = 133
    let xb = 311
    let ya, yb
    let _a, _b

    //Public Key Alice
    ya = mpmod(a, xa, q)
    //Public Key Bob
    yb = mpmod(a, xb, q)

    //Secret
    _a = mpmod(yb, xa, q)
    _b = mpmod(ya, xb, q)

    let arr = [xa, xb, ya, yb, _a, _b]

    text.innerHTML = '<h1>Result: ' + arr + '</h1>'
})