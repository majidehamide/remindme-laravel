FROM node:latest
WORKDIR /app
COPY package.json .
COPY .env.example .env
RUN npm install 
COPY . .
EXPOSE 3000
RUN npm run build
CMD ["npm", "run", "dev", "--","--host"]