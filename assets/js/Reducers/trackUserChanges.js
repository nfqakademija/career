const initialState = {
  choiceAnswers: [],
  comment: [],
  isActionCalled: false
};

export const trackUserChanges = (state = initialState, action) => {
  switch (action.type) {
    case "setAnswers":
      let obj = {
        criteriaId: action.criteriaId,
        choiceId: action.choiceId,
        answerId: action.answerId
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
        comment: action.comment,
        answerId: action.answerId
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
      case 'isActionCalled':
        return{
          ...state,
          isActionCalled: action.bollean
        }

    default:
      return state;
  }
};
