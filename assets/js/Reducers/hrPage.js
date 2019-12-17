const initialState = {
  profiles: [],
  positions: [],
  currentPosition: null,
  competenceList: [],
  criteriaList: [],
  show: [],
  positionIncludedCriterias: []
};

export const hrPage = (state = initialState, action) => {
  switch (action.type) {
    case "setProfiles":
      return {
        ...state,
        profiles: action.profiles
      };
    case "setPositions":
      return {
        ...state,
        positions: action.positions
      };
    case "setCurrentPosition":
      return {
        ...state,
        currentPosition: action.currentPosition
      };
    case "setCompetenceList":
      return {
        ...state,
        competenceList: action.competenceList
      };
    case "setCriteriaList":
      return {
        ...state,
        criteriaList: action.criteriaList
      };
    case "setPositionIncludedCriterias":
      return {
        ...state,
        positionIncludedCriterias: action.positionIncludedCriterias
      };
    default:
      return state;
  }
};
