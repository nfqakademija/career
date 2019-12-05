const initialState = {
  choiceAnswers: []
};

export const trackUserChanges = (state = initialState, action) => {
  switch (action.type) {
    case "setAnswers":
      return {
        ...state,
        choiceAnswers: state.choiceAnswers.concat(action.answer)
      };
    // case "removeAnswer":
    //   const index = state.choiceAnswers.indexOf(action.answer);
    //   const newArray = state.choiceAnswers.splice(index, 1);
    //   return {
    //     ...state,
    //     choiceAnswers: newArray
    //   };
    default:
      return state;
  }
};
