FROM node:20-alpine3.20 AS base
ARG MODE=development
ENV NODE_ENV=$MODE
ENV PORT=3000

WORKDIR /app

COPY package*.json ./
RUN npm i
COPY . .

EXPOSE $PORT

CMD ["npm", "run", "dev"]