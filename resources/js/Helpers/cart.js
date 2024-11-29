export const addToCart = (product) => {
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        cart.products = cart.products || [];
        if (!cart.products.some(p => p.id === product.id)) {
            cart.products.push({
                ...product,
                quantity: 1,
            });
        } else {
            cart.products = cart.products.map(p => {
                if (p.id === product.id) {
                    p.quantity += 1;
                }
                return p;
            });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
    } catch (e) {
        localStorage.removeItem('cart');
        console.error(e);
    }
};

export const listProducts = () => {
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        const products = cart.products || [];
        return products.filter(p => p.quantity > 0 && p.id);
    } catch (e) {
        localStorage.removeItem('cart');
        console.error(e);
    }
};

export const removeFromCart = (product) => {
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        cart.products = cart.products || [];
        cart.products = cart.products.filter(p => p.id !== product.id);
        localStorage.setItem('cart', JSON.stringify(cart));
    } catch (e) {
        localStorage.removeItem('cart');
        console.error(e);
    }
}

export const clearCart = () => {
    try {
        localStorage.removeItem('cart');
    } catch (e) {
        console.error(e);
    }
};

export const updateCart = (product, quantity) => {
    try {
        if (quantity <= 0) {
            removeFromCart(product);
            return;
        }

        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        cart.products = cart.products || [];
        cart.products = cart.products.map(p => {
            if (p.id === product.id) {
                p.quantity = quantity;
            }
            return p;
        });
        localStorage.setItem('cart', JSON.stringify(cart));
    } catch (e) {
        localStorage.removeItem('cart');
        console.error(e);
    }
}

export const calculateTotal = () => {
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        return cart.products.reduce((total, product) => {
            return total + product.price * product.quantity;
        }, 0);
    } catch (e) {
        localStorage.removeItem('cart');
        console.error(e);
    }
}
