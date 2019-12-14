export const checkForAnswerId = (choices, criteriaId) => {
  for (let i = 0; i < choices.length; i++) {
    if (choices[i].criteriaId === criteriaId) {
      return choices[i].answerId;
    }
  }
  return null;
};
