const initialState = {
  choiceAnswers: [],
  comment: []
};

export const trackUserChanges = (state = initialState, action) => {
  switch (action.type) {
    case "setAnswers":
      let obj = {
        criteriaId: action.criteriaId,
        choiceId: action.choiceId,
      };
      let answer = state.choiceAnswers;
      for (let i = 0; i < answer.length; i++) {
        if (answer[i].criteriaId === obj.criteriaId) {
          answer.splice(i, 1);
        }
      }
      if (Number(action.criteriaId)) {
        answer.push(obj);
      }
      return {
        ...state,
        choiceAnswers: answer
      };
    case "setComment":
      obj = {
        criteriaId: action.criteriaId,
        comment: action.comment
      };
      answer = state.comment;
      for (let i = 0; i < answer.length; i++) {
        if (answer[i].criteriaId === obj.criteriaId) {
          answer.splice(i, 1);
        }
      }
      if (Number(action.criteriaId)) {
        answer.push(obj);
      }
      return {
        ...state,
        comment: answer
      };

    case "restartAnswers":
      return {
        ...state,
        choiceAnswers: [],
        comment: []
      };

    default:
      return state;
  }
};
