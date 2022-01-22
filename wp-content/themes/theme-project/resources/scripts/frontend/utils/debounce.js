/**
 * Debounce
 * @param {Function} func
 * @param {Number} delay
 */

const debounce = (func, delay) => {
  let inDebounce;

  return (...args) => {
    const that = this;

    clearTimeout(inDebounce);
    inDebounce = setTimeout(() => func.apply(that, args), delay);
  };
};

export default debounce;
