const initialState = {
    choiceList: []
  };
  
  export const answerListTeamLeadSide = (state = initialState, action) => {
    switch (action.type) {
      case "setAnswersFromTeamLead":
        return {
          ...state,
          choiceList: action.answers
        };
      case "updateChoiceAnswerTeamLead":
        let copy = state.choiceList;
        let found = false;
        for (let i = 0; i < copy.length; i++) {
          if (copy[i].criteriaId === action.criteriaId) {
            copy[i].choiceId = Number(action.choiceId);
            found = true;
          }
        }
        if (found === false) {
          const obj = {
            criteriaId: action.criteriaId,
            choiceId: Number(action.choiceId),
            comment: null
          };
          copy.push(obj);
        }
        return {
          ...state,
          choiceList: copy
        };
  
      case "updateCommentAnswerTeamLead":
        copy = state.choiceList;
        found = false;
        for (let i = 0; i < copy.length; i++) {
          if (copy[i].criteriaId === action.criteriaId) {
            copy[i].comment = action.comment;
            found = true;
          }
        }
        if (found === false) {
          const obj = {
            criteriaId: action.criteriaId,
            choiceId: null,
            comment: action.comment
          };
          copy.push(obj);
        }
        return {
          ...state,
          choiceList: copy
        };
      case "restartAnswersFromUserTeamLead":
        return {
          ...state,
          choiceList: []
        };
      default:
        return state;
    }
  };
  